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
        if ($this->session->userdata('logged_in') && $this->session->userdata('user_type') != 1) {
            redirect('dashboard');
        }
        else {
            $this->load->view('login');
        }
    }

    public function authenticate() {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username and Password are required.');
            redirect('login');
        }

        $user = $this->login_model->login($username, $password);

        if ($user) {
            $this->session->set_userdata('user_id', $user->user_id);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('fullname', $user->fullname);
            $this->session->set_userdata('user_type', $user->user_type);
            $this->session->set_userdata('logged_in', true);

            switch($user->user_type) {
                case 1:
                    redirect('admin');
                    break;
                case 2:
                    redirect('dashboard');
                    break;
                case 3:
                    redirect('dashboard');
                    break;
                case 4:
                    redirect('revalidate');
                    break;
                case 5:
                    redirect('dashboard');
                    break;
            }
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
