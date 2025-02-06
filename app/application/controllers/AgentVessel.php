<?php
class AgentVessel extends CI_Controller {
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
        if ($this->session->userdata('user_type') == 3) {
            $this->load->view('agent-vessel');
        }
        else {
            redirect('dashboard');
        }
    }

    public function view($id) {
        if ($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 4) {
            $data['id'] = $id;
            $data['vessel_data'] = $this->Liquidation_model->get_vessel_data($id);
            $data['vessel_items'] = $this->Liquidation_model->get_vessel_items($data['vessel_data'][0]->transno);
            $data['notes'] = $this->Liquidation_model->get_notes($data['id']);

            $this->load->view('agent-vessel', $data);
        } else {
            redirect('dashboard');
        }
    }
    public function acctg_validate_bulk() {
        $items = $this->input->post('items'); // Array of items
        
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                // Loop through each item and update it
                $updatedId = $this->Liquidation_model->update_item_by_acctg($item['item_id']);
            }
            
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No items to update.'));
        }
    }
    
    public function voo_om_validate_bulk() {
        $items = $this->input->post('items'); // Array of items
    
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                // Loop through each item and update it
                $updatedId = $this->Liquidation_model->update_item_by_voo_om($item['item_id']);
            }
    
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No items to update.'));
        }
    }
    
}
?>