<?php
class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index() {
        if ($this->session->userdata('user_type') == 1) {
            $this->load->view('admin-panel');
        }
        else {
            redirect('login');
        }
    }
}
?>