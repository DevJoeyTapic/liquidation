<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $this->load->view('login');
    }

    public function authenticate() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username and Password are required.');
            redirect('login');
        }

        $user = $this->login_model->login($username, $password);

        if ($user) {
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('user_type', $user->user_type);
            $this->session->set_userdata('logged_in', true);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
