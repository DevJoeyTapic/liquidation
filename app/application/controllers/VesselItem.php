<?php
class VesselItem extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Liquidation_model');
        $this->load->library('session');    

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    public function view($id) {
        if ($this->session->userdata('user_type') == 2) {
            $user_id = $this->session->userdata('user_id');
            $data['agent_liquidations'] = $this->Liquidation_model->get_agent_liquidations($user_id);  
            $data['vessel_data'] = $this->Liquidation_model->get_vessel_data($id);
            
            // Get data related to the vessel item
            $data['id'] = $id;
            $data['vessel_items'] = $this->Liquidation_model->get_vessel_items($data['id']);
            $data['liquidation_item'] = $this->Liquidation_model->get_liquidation_item($user_id, $id);
            $data['notes'] = $this->Liquidation_model->get_notes($data['id']);

            $this->load->view('vessel-item', $data);
            
        } else {
            redirect('dashboard');
        }
    }

    public function archive($id) {
        if ($this->session->userdata('user_type') == 2) {
            $data['archive_complete'] = $this->Liquidation_model->mark_complete_archive($id);
            if ($data['archive_complete']) {
                redirect('dashboard');
            } else {
                $this->load->view('vessel-item', $data);
            }
        }
    }

    public function add_item() {
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'supplier' => $this->input->post('supplier'),
            'transno' => $this->input->post('transno'),
            'item' => $this->input->post('newItem'),
            'remarks' => $this->input->post('newRemarks'),
            'actual_amount' => $this->input->post('newAmount'),
            'isNew' => $this->input->post('isNew')
        );
        $insertedId = $this->Liquidation_model->insert_item($data);
        if ($insertedId) {
            echo json_encode(array('status' => 'success', 'id' => $insertedId));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to add item'));
        }
        
    }
    
    public function submit_voo_om($id) {
        $item_id = $this->input->post('item_id');
        $actual_amount = $this->input->post('actualAmount');
        $variance = $this->input->post('variance');
        $updatedId = $this->Liquidation_model->update_item_for_voo_om($id);
        if ($updatedId) {
            echo json_encode(array('status' => 'success', 'id' => $updatedId));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update
             item'));
        }
    }

    public function submit_acctg($id) {
        $item_id = $this->input->post('item_id');
        $updatedId = $this->Liquidation_model->update_item_for_acctg($id);
        if ($updatedId) {
            echo json_encode(array('status' => 'success', 'id' => $updatedId));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update
             item'));
        }
    }


    

}
?>