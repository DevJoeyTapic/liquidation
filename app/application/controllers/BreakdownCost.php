<?php
    class BreakdownCost extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->load->model('Liquidation_model');
            $this->load->model('Breakdown_model');
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
                'rfp_amount' => $this->input->post('rfp_amount'),
                'variance' => $this->input->post('variance')
            );
            $insertedId = $this->Breakdown_model->add_breakdown_cost($data);
            echo $this->db->last_query();
        }

        public function get_breakdown_cost($item_id) { 
            $breakdown_cost = $this->Breakdown_model->get_breakdown_cost($item_id);
            $data['breakdown_cost'] = $breakdown_cost;
            $data['item_id'] = $item_id;
            $this->load->view('vessel-item', $data);
        }

    }
?>