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
    public function view($vessel, $voyage) {
        if ($this->session->userdata('user_type') == 2) {
            $data['vessel'] = $vessel;
            $data['voyage'] = $voyage;
            $data['vessel_items'] = $this->Liquidation_model->get_vessel_items($data['vessel'], $data['voyage']);
            $this->load->view('vessel-item', $data);
        }
        else {
            redirect('dashboard');
        }
    }
}
?>