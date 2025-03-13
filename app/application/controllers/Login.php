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
        // Get username and password from form input
        $username = $this->input->post('username');
        $password = $this->input->post('password');  // No need to hash the password here, we will hash it manually in the controller
    
        // Check if the username or password is empty
        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username and Password are required.');
            redirect('login');
        }
    
        // Hash the password manually in the controller using password_hash()
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Pass both the username and the hashed password to the login model
        $user = $this->login_model->login($username, $hashed_password);
    
        // Check if user exists and verify the password
        if ($user) {
            // Password matches, set session variables
            $this->session->set_userdata('user_id', $user->user_id);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('fullname', $user->fullname);
            $this->session->set_userdata('user_type', $user->user_type);
            $this->session->set_userdata('logged_in', true);
    
            // Redirect user based on their user type
            switch ($user->user_type) {
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
                    redirect('dashboard');
                    break;
                default:
                    redirect('login');
                    break;
            }
        } else {
            // Invalid username or password
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('login');
        }
    }
    
    
    

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
?>