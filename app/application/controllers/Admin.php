<?php
class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session', 'form_validation');
        $this->load->helper('form', 'url');
        $this->load->model('User_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index() {
        $data['users'] = $this->User_model->get_users();
        $this->load->view('admin-panel', $data);
    }
    public function addUser() {

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('fullname', 'Full Name', 'required');
        $this->form_validation->set_rules('email', 'Email');
        $this->form_validation->set_rules('user_type', 'Role', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin-panel');
        } else {
            // Check for duplicate username and email
            $username = $this->input->post('username');
            $email = $this->input->post('email');
    
            $this->db->where('username', $username);
            $username_check = $this->db->get('user_account');
    
            $this->db->where('email', $email);
            $email_check = $this->db->get('user_account');
    
            if ($username_check->num_rows() > 0) {
                $this->session->set_flashdata('error', 'Username already exists.');
                redirect('admin');
            } elseif ($email_check->num_rows() > 0) {
                $this->session->set_flashdata('error', 'Email already exists.');
                redirect('admin');
            } else {
                $hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                $data = array(
                    'username' => $this->input->post('username'),
                    'password' => $hashed_password,
                    'fullname' => $this->input->post('fullname'),
                    'email' => $this->input->post('email'),
                    'user_type' => $this->input->post('user_type')
                );
                if ($this->User_model->add_user($data)) {
                    $this->session->set_flashdata('success', 'User added successfully!');
                    redirect('admin');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add user, please try again.');
                    redirect('admin');
                }
            }
        }
    }
    
    public function updateUser() {
        $user_id = $this->input->post('user_id');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $fullname = $this->input->post('fullname');
        $email = $this->input->post('email');
        $user_type = $this->input->post('user_type');  
        $is_active = $this->input->post('is_active') ? 1 : 0;

        $data = array(
            'username' => $username,
            'password' => $hashed_password,
            'fullname' => $fullname,
            'email' => $email,
            'user_type' => $user_type,
            'is_active' => $is_active
        );

        if($this->User_model->update_user($user_id, $data)) {
            $this->session->set_flashdata('success', 'User updated successfully!');
            redirect('admin');
        } else {
            $this->session->set_flashdata('error', 'Failed to update user, please try again.');
            redirect('admin');
        }
        
    }
}
?>