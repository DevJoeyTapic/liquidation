<?php
class Liquidation_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_accounting_liquidations() {
        $sql = "SELECT * FROM accounting_liquidations";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_agent_liquidations($user_id) {
        $sql = "SELECT * FROM tbl_agent_liquidation WHERE user_id = ?";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }
    public function get_vessel_data($id) {
        $sql = "SELECT * FROM tbl_agent_liquidation WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }
    public function get_user_type() {
        $query = $this->db->get_where('user_account', ['id' => $this->session->userdata('user_id')]);
        if ($query->num_rows() > 0) {
            return $query->row()->user_type;
        }
        return null;
    }
    public function get_vessel_items($id) {
        $sql = "SELECT * FROM agent_liquidations WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        
        return $query->result();
    }
    
    public function get_liquidation_item($user_id, $id) {
        $sql = "SELECT * FROM tbl_agent_liquidation_items AS i
                INNER JOIN tbl_agent_liquidation AS l
                ON i.transno = l.transno
                WHERE i.user_id = ? AND l.id = ?";
        $query = $this->db->query($sql, array($user_id, $id));
        return $query->result();
    }

    public function get_notes($liq_ref) {
        $sql = "SELECT * FROM notes_master WHERE liq_ref = ?";
        $query = $this->db->query($sql, array($liq_ref));
        return $query->result();
    }
    public function insert_note($liq_ref, $sender, $notes, $timestamp) {
        $data = [
            'liq_ref' => $liq_ref,
            'sender' => $sender,
            'notes' => $notes,
            'timestamp' => $timestamp
        ];
        $this->db->insert('notes_master', $data);
    }
    


    
}
?>