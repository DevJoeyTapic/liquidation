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
        if ($this->session->userdata('user_type') == 3) {
            $data['vessel_data'] = $this->Liquidation_model->get_vessel_data($id);
            $data['vessel_items'] = $this->Liquidation_model->get_vessel_items($data['vessel_data'][0]->transno);
            $this->load->view('agent-vessel', $data);
        } else {
            redirect('dashboard');
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