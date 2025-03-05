<?php
class VesselItem extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Liquidation_model');
        $this->load->model('VesselItem_model');
        $this->load->model('CreditBreakdown_model');
        $this->load->model('Breakdown_model');
        $this->load->model('Notes_model');
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
            $data['liquidation_item'] = $this->VesselItem_model->get_liquidation_items($user_id, $id);
            $data['credit_breakdown'] = $this->CreditBreakdown_model->get_credit_breakdown($user_id);
            $data['total_php'] = $this->CreditBreakdown_model->get_total_php($user_id);
            $data['total_usd'] = $this->CreditBreakdown_model->get_total_usd($user_id);
            $data['notes'] = $this->Notes_model->get_notes($data['id']);

            $item_ids = array_column($data['liquidation_item'], 'id');  
            if (!empty($item_ids)) {
                $data['breakdown_cost'] = $this->Breakdown_model->get_breakdown_cost($item_ids);
            } else {
                $data['breakdown_cost'] = [];  
            }
    
            // Load the view
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
            'currency' => $this->input->post('currency'),
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
    
    public function submit_for_validation() {
        $items = $this->input->post('items');  // Receives an array of items
        if ($items) {
            foreach ($items as $data) {
                $updatedId = $this->VesselItem_model->update_item_agent($data);
            }
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No data provided.'));
        }
        
    }
    public function submit_for_amendment() {
        $items = $this->input->post('items');  // Receives an array of items
        if ($items) {
            foreach ($items as $data) {
                $updatedId = $this->VesselItem_model->update_item_agent($data);
            }
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No data provided.'));
        }
    }

    public function get_item_remarks($item_id) {
        try {
            $remarks_data = $this->Liquidation_model->get_item_remarks($item_id);
            if ($remarks_data) {
                echo json_encode($remarks_data);
            } else {
                echo json_encode(['error' => 'No remarks found for this item.']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function add_item_remark() {
        $data = array(
            'item_id' => $this->input->post('item_id'),
            'remarks' => $this->input->post('remarks'),
            'author' => $this->input->post('author'),
            'timestamp' => $this->input->post('timestamp')
        );
        $insertedId = $this->Liquidation_model->insert_item_remark($data);
        if ($insertedId) {
            echo json_encode(array('status' => 'success', 'id' => $insertedId));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to add remark'));
        }
    }
}

?>