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
            
            // Handle form submission
            if ($this->input->post('liq_ref') && $this->input->post('sender') && $this->input->post('timestamp')) {
                $liq_ref = $this->input->post('liq_ref');
                $sender = $this->input->post('sender');
                $timestamp = $this->input->post('timestamp');
                $notes = $this->input->post('notes'); // Make sure to add a message field in your form
    
                // You might want to insert this data into a database or perform some other action.
                $this->Liquidation_model->insert_note($liq_ref, $sender, $notes, $timestamp);
                
            }
            
            $this->load->view('vessel-item', $data);
        } else {
            redirect('dashboard');
        }
    }
    

}
?>