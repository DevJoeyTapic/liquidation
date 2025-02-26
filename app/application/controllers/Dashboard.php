<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->model('Login_model');
        $this->load->library('session');
        $this->load->model('User_model');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $user_type = $this->session->userdata('user_type');

        switch($user_type) {
            case 1: // Admin
                $this->load->view('admin-panel');
                break;
            case 2: // Agent
                $user_id = $this->session->userdata('user_id');
                $data['unliquidated_vessels'] = $this->Dashboard_model->get_unliquidatedAg($user_id);
                $data['pending_validation'] = $this->Dashboard_model->get_pendingValidationAg($user_id);
                $data['completed'] = $this->Dashboard_model->get_completedAg($user_id);
                $data['for_amendment'] = $this->Dashboard_model->get_forAmendmentAg($user_id);
                $this->load->view('dashboard', $data);
                break;
            case 3: // Accounting
                $data['unliquidated_vessels'] = $this->Dashboard_model->get_unliquidated();
                $data['pending_validation'] = $this->Dashboard_model->get_pendingValidationAcc();
                $data['for_amendment'] = $this->Dashboard_model->get_forAmendmentAcc();
                $data['completed'] = $this->Dashboard_model->get_completed();
                $this->load->view('dashboard', $data);
                break;
            case 5: // TAD
                $data['unliquidated_vessels'] = $this->Dashboard_model->get_unliquidated();
                $data['pending_otp'] = $this->Dashboard_model->get_pendingOTP();
                $data['completed'] = $this->Dashboard_model->get_completed();
                $this->load->view('dashboard', $data);
                break;
            default:               
                $this->load->view('login');
        }
    }
}
