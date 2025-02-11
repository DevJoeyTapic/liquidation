<?php
    class BreakdownCost extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->load->model('Liquidation_model');
            $this->load->library('session');    

            if (!$this->session->userdata('logged_in')) {
                redirect('login');
            }
        }

        public function add_breakdown_cost() {
            $data = array(
                'description' => $this->input->post('description'),
                'amount' => $this->input->post('amount'),
                'item_id' => $this->input->post('item_id'),
                'rfp_no' => $this->input->post('rfp_no'),
                'currency' => $this->input->post('currency'),
                'rfp_amount' => $this->input->post('rfp_amount')
            );
            
            
            $insertedId = $this->Liquidation_model->add_breakdown_cost($data);
            if ($insertedId) {
                echo json_encode(array('status' => 'success', 'id' => $insertedId));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Failed to add remark'));
            }
        }
    }
?>