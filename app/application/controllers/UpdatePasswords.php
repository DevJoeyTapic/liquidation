<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UpdatePasswords extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        if ($this->session->userdata('user_type') == 1) {
            $users = $this->User_model->get_users();

            if ($users) {
            foreach ($users as $user) {
                if (password_verify($user->password, $user->password)) {
                continue;
                }

                $hashed_password = password_hash($user->password, PASSWORD_DEFAULT);
                $this->User_model->update_all_users($user->user_id, $hashed_password);
            }

            $this->session->set_flashdata('success', 'All user passwords have been updated to hashed passwords.');
            redirect('admin');
            } else {
            $this->session->set_flashdata('error', 'No users found to update.');
            redirect('admin');
            }
        } else {
            $this->session->set_flashdata('error', 'You do not have permission to perform this action.');
            redirect('login');
        }
    }
}
