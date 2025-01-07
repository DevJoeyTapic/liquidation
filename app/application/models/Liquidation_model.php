<?php
class Liquidation_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_accounting_liquidations() {
        $query = $this->db->get('accounting_liquidations');
        return $query->result();
    }

    public function get_agent_liquidations() {
        $query = $this->db->get('agent_liquidations');
        return $query->result();
    }

    public function get_user_type() {
        $query = $this->db->get_where('user_account', ['id' => $this->session->userdata('user_id')]);
        if ($query->num_rows() > 0) {
            return $query->row()->user_type;
        }
        return null;
    }
    public function get_vessel_items($vessel, $voyage) {
        $query = $this->db->get_where('agent_liquidations', ['vessel' => $vessel, 'voyage' => $voyage]);
        return $query->result();
    }
}
?>