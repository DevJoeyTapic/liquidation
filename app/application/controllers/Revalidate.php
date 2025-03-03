<?php
class Revalidate extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('AgentVessel_model');
        $this->load->library('session');    

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function get_for_am() {
        if($this->session->userdata('user_type') == '4') {
            $data['for_am'] = $this->AgentVessel_model->get_for_am();
            $this->load->view('revalidate', $data);
        } else {
            redirect('login');
        }
        
    }
    public function pay_to_agent() {
        $items = $this->input->post('items');  // Receives an array of items
        if ($items) {
            foreach ($items as $data) {
                $updatedId = $this->AgentVessel_model->pay_to_agent($data);
            }
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No data provided.'));
        }
    }
    public function return_to_apar() {
        $items = $this->input->post('items');  // Receives an array of items
        if ($items) {
            foreach ($items as $data) {
                $updatedId = $this->AgentVessel_model->return_to_apar($data);
            }
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No data provided.'));
        }
    }

    // public function submit_for_revalidation() {
    //     $items = $this->input->post('items'); // Array of items
    //     if (is_array($items) && count($items) > 0) {
    //         foreach ($items as $item) {
    //             $updatedId = $this->Liquidation_model->revalidate_item($item['item_id']);
    //         }
            
    //         echo json_encode(array('status' => 'success'));
    //     } else {
    //         echo json_encode(array('status' => 'error', 'message' => 'No items to revalidate.'));
    //     }
    // }
}