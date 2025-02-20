<?php
class Revalidate extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Liquidation_model');
        $this->load->library('session');    

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        if($this->session->userdata('user_type') == '4') {
            $data['revalidated_liquidations'] = $this->Liquidation_model->get_revalidated_liquidations();
            $this->load->view('revalidate', $data);
        } else {
            redirect('login');
        }
    }

    public function submit_for_revalidation() {
        $items = $this->input->post('items'); // Array of items
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                $updatedId = $this->Liquidation_model->revalidate_item($item['item_id']);
            }
            
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No items to revalidate.'));
        }
    }
}