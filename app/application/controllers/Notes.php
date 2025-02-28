<?php
    class Notes extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->load->model('Notes_model');
            $this->load->library('session');    

            if (!$this->session->userdata('logged_in')) {
                redirect('login');
            }
        }
        public function get_notes($liq_ref) {
            $data['notes'] = $this->Notes_model->get_notes($liq_ref);
            $this->load->view('vessel-item', $data);
            echo json_encode($notes);
        }
    }
?>
