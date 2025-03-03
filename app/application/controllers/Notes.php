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
        public function add_notes() {
            $data = array(
                'liq_ref' => $this->input->post('liq_ref'),
                'sender' => $this->input->post('sender'),
                'notes' => $this->input->post('notes'),
                'timestamp' => $this->input->post('timestamp')
            );
            $insertedId = $this->Notes_model->insert_notes($data);
            if ($insertedId) {
                echo json_encode(array('status' => 'success', 'id' => $insertedId));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Failed to add remark'));
            }
        }
    }
?>
