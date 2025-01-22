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

    public function get_agent_liquidations() {
        $sql = "SELECT * FROM agent_liquidations";
        $query = $this->db->query($sql);
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
    
    public function get_liquidation_master($user_id) {
        $sql = "SELECT * FROM liquidation_master WHERE user_id = ?";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }
    
    public function get_notes_master($epda_ref) {
        if (empty($epda_ref)) {
            return [];
        }
    
        $sql = "SELECT * FROM notes_master WHERE epda_ref = ?";
        $query = $this->db->query($sql, array($epda_ref));
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }
    
    
}
?>