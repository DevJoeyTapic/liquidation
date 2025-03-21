<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->model('CreditBreakdown_model');
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
                $data['credit_breakdown'] = $this->CreditBreakdown_model->get_credit_breakdown($user_id);
                $data['total_php'] = $this->CreditBreakdown_model->get_total_php($user_id);
                $data['total_usd'] = $this->CreditBreakdown_model->get_total_usd($user_id);
                $data['due_agent_controlled'] = $this->CreditBreakdown_model->total_due_controlled($user_id);
                $data['controlled_total'] = $this->CreditBreakdown_model->controlled_total($user_id);
                $this->load->view('dashboard', $data);
                break;
            case 3: // Accounting
                $user_id = $this->session->userdata('user_id');
                $data['unliquidated_vessels'] = $this->Dashboard_model->get_unliquidated();
                $data['pending_validation'] = $this->Dashboard_model->get_pendingValidationAcc();
                $data['for_amendment'] = $this->Dashboard_model->get_forAmendmentAcc();
                $data['completed'] = $this->Dashboard_model->get_completed();
                $data['credit_breakdown'] = $this->CreditBreakdown_model->get_credit_breakdown($user_id);
                $data['total_php'] = $this->CreditBreakdown_model->get_total_php($user_id);
                $data['total_usd'] = $this->CreditBreakdown_model->get_total_usd($user_id);
                $data['credit_breakdown'] = $this->CreditBreakdown_model->get_all_credit_breakdown();
                $data['total_php'] = $this->CreditBreakdown_model->get_all_total_php();
                $data['total_usd'] = $this->CreditBreakdown_model->get_all_total_usd();
                $data['due_agent_controlled'] = $this->CreditBreakdown_model->all_total_due_controlled();
                $data['controlled_total'] = $this->CreditBreakdown_model->all_controlled_total();
                $this->load->view('dashboard', $data);
                break;
            case 5: // TAD
                $user_id = $this->session->userdata('user_id');
                $data['unliquidated_vessels'] = $this->Dashboard_model->get_unliquidated();
                $data['pending_otp'] = $this->Dashboard_model->get_pendingOTP();
                $data['completed'] = $this->Dashboard_model->get_completed();
                $data['credit_breakdown'] = $this->CreditBreakdown_model->get_credit_breakdown($user_id);
                $data['total_php'] = $this->CreditBreakdown_model->get_total_php($user_id);
                $data['total_usd'] = $this->CreditBreakdown_model->get_total_usd($user_id);
                $data['credit_breakdown'] = $this->CreditBreakdown_model->get_all_credit_breakdown();
                $data['total_php'] = $this->CreditBreakdown_model->get_all_total_php();
                $data['total_usd'] = $this->CreditBreakdown_model->get_all_total_usd();
                $data['due_agent_controlled'] = $this->CreditBreakdown_model->all_total_due_controlled();
                $data['controlled_total'] = $this->CreditBreakdown_model->all_controlled_total();
                $this->load->view('dashboard', $data);
                break;
            default:               
                $this->load->view('login');
        }
    }
}
