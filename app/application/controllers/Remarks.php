<?php
    class Remarks extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->load->model('Liquidation_model');
            $this->load->library('session');    

            if (!$this->session->userdata('logged_in')) {
                redirect('login');
            }
        }

        public function get_item_remarks($item_id) {
            try {
                $remarks_data = $this->Liquidation_model->get_item_remarks($item_id);
                if ($remarks_data) {
                    echo json_encode($remarks_data);
                } else {
                    echo json_encode(['error' => 'No remarks found for this item.']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        }

        public function add_item_remark() {
            $data = array(
                'item_id' => $this->input->post('item_id'),
                'remarks' => $this->input->post('remarks'),
                'author' => $this->input->post('author'),
                'timestamp' => $this->input->post('timestamp')
            );
            $insertedId = $this->Liquidation_model->insert_item_remark($data);
            if ($insertedId) {
                echo json_encode(array('status' => 'success', 'id' => $insertedId));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Failed to add remark'));
            }
        }
    }
?>