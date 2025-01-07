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
}
?>