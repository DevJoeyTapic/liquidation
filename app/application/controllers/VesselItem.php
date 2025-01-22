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
    public function index() {
        if ($this->session->userdata('user_type') == 2) {
            $data['agent_liquidations'] = $this->Liquidation_model->get_agent_liquidations();   
            $this->load->view('vessel-item', $data);
        }
        else {
            redirect('dashboard');
        }
    }
    public function view($id) {
        if ($this->session->userdata('user_type') == 2) {
            $user_id = $this->session->userdata('user_id');
            $data['agent_liquidations'] = $this->Liquidation_model->get_agent_liquidations();  
            foreach ($data['agent_liquidations'] as $liquidation) {
                if ($liquidation->id == $id) {
                    $data['vessel'] = $liquidation->vessel;
                    $data['voyage'] = $liquidation->voyage;
                    $data['port'] = $liquidation->port;
                    $data['eta'] = $liquidation->eta;
                    $data['etd'] = $liquidation->etd;
                    break;
                }
            }
            $data['id'] = $id;
            $data['vessel_items'] = $this->Liquidation_model->get_vessel_items($data['id']);
            $data['liquidation_master'] = $this->Liquidation_model->get_liquidation_master($user_id);
            $this->load->view('vessel-item', $data);
            
        }
        else {
            redirect('dashboard');
        }
    }

    public function notes($epda_ref) {
        if ($this->session->userdata('user_type') == 2 || $this->session->userdata('user_type') == 3) {
            $data['notes_master'] = $this->Liquidation_model->get_notes_master($epda_ref);
    
            if (empty($data['notes_master'])) {
                log_message('error', 'No notes found for EPDA reference: ' . $epda_ref);
            }
    
            $this->load->view('vessel-item', $data);
        } else {
            redirect('dashboard');
        }
    }
    
}
?>