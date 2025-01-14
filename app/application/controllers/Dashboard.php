<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Liquidation_model');
        $this->load->model('Login_model');
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $user_type = $this->session->userdata('user_type');

        switch($user_type) {
            case 1: // Admin
                // $data['agent_liquidations'] = $this->Liquidation_model->get_agent_liquidations();
                $this->load->view('dashboard');
                break;
            case 2: // Agent
                $data['agent_liquidations'] = $this->Liquidation_model->get_agent_liquidations();
                $this->load->view('dashboard', $data);
                break;
            case 3: // Accounting
                $data['accounting_liquidations'] = $this->Liquidation_model->get_accounting_liquidations();
                $this->load->view('dashboard', $data);
                break;
            default:               
                $this->load->view('dashboard');
        }
    }
}
