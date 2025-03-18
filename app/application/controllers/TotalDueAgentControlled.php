<?php
class TotalDueAgentControlled extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('CreditBreakdown_model');
        $this->load->library('session');    
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['total_due_agent'] = $this->CreditBreakdown_model->total_due_controlled($user_id);
    }

}
?>