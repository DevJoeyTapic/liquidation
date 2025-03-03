<?php
class AgentVessel extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Liquidation_model');
        $this->load->model('AgentVessel_model');
        $this->load->model('Notes_model');
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
        if ($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5) {
            $data['id'] = $id;
            $data['vessel_data'] = $this->Liquidation_model->get_vessel_data($id);
            $data['vessel_items'] = $this->Liquidation_model->get_vessel_items($data['vessel_data'][0]->transno);
            $data['notes'] = $this->Notes_model->get_notes($data['id']);

            $this->load->view('agent-vessel', $data);
        } else {
            redirect('dashboard');
        }
    }
    
    
    public function ok_to_pay() {
        $items = $this->input->post('items');  // Receives an array of items
        if ($items) {
            foreach ($items as $data) {
                $updatedId = $this->AgentVessel_model->ok_to_pay($data);
            }
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No data provided.'));
        }
    }
    
    public function for_amendment_tad() {
        $items = $this->input->post('items');  // Receives an array of items
        if ($items) {
            foreach ($items as $data) {
                $updatedId = $this->AgentVessel_model->for_amendment_tad($data);
            }
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No data provided.'));
        }
    }
    public function for_amendment_acctg() {
        $items = $this->input->post('items');  // Receives an array of items
        if ($items) {
            foreach ($items as $data) {
                $updatedId = $this->AgentVessel_model->for_amendment_acctg($data);
            }
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No data provided.'));
        }
    }
    public function submit_to_am() {
        $items = $this->input->post('items');  // Receives an array of items
        if ($items) {
            foreach ($items as $data) {
                $updatedId = $this->AgentVessel_model->submit_to_am($data);
            }
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No data provided.'));
        }
    }
    
}
?>