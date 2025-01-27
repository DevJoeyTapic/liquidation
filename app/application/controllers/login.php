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

            if ($user->user_type == 1) {
                redirect('admin');
                } else {
                redirect('dashboard');
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
    public function change_password() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
        
        if($this->form_validation->run() == FALSE) {
            $this->load->view('dashboard');
        } else {
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');
            
            $user = $this->login_model->change_password($this->session->userdata('username'), $old_password);
            
            if ($user) {
                $this->login_model->update_password($this->session->userdata('username'), $new_password);
                $this->session->set_flashdata('success', 'Password changed successfully');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid old password');
                redirect('change_password');
            }
        }
        
        $this->load->model('login_model');
    }
}
