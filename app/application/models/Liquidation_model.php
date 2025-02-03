<?php
class Liquidation_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_accounting_liquidations() {
        $sql = "SELECT
                l.id,
                l.user_id,
                l.supplier,
                l.transno,
                l.vessel_name,
                l.voyno,
                l.`port`,
                l.`status`
                FROM tbl_agent_liquidation AS l
                INNER JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno
                WHERE i.`status` = 2 AND l.`status` = 1
                GROUP BY l.transno, l.voyno";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_tad_liquidations() {
        $sql = "SELECT
                l.id,
                l.user_id,
                l.supplier,
                l.transno,
                l.vessel_name,
                l.voyno,
                l.`port`,
                l.`status`
                FROM tbl_agent_liquidation AS l
                INNER JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno
                WHERE i.`status` = 1 AND l.`status` = 1
                GROUP BY l.transno, l.voyno";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_agent_liquidations($user_id) {
        $sql = "SELECT * FROM tbl_agent_liquidation
                WHERE user_id = ?";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }
    public function get_vessel_data($id) {
        $sql = "SELECT * FROM tbl_agent_liquidation
                WHERE id = ?";
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
    public function get_vessel_items($transno) {
        $sql = "SELECT * FROM tbl_agent_liquidation_items
                WHERE transno = ?";
        $query = $this->db->query($sql, array($transno));
        return $query->result();
    }
    
    public function get_liquidation_item($user_id, $id) {
        $sql = "SELECT 
                i.id, i.user_id, i.supplier, i.transno, i.transno, i.item, i.rfp_no, i.currency, i.rfp_amount, i.actual_amount, i.`variance`, i.remarks, i.doc_ref, i.status, i.controlled, i.isNew
                FROM tbl_agent_liquidation_items AS i
                INNER JOIN tbl_agent_liquidation AS l
                ON i.transno = l.transno
                WHERE i.user_id = ? AND l.id = ?";
        $query = $this->db->query($sql, array($user_id, $id));
        return $query->result();
    }

    public function mark_complete_archive($id) {
        $sql = "UPDATE tbl_agent_liquidation
                SET STATUS = 2
                WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        return $this->db->affected_rows() > 0;
    }

    public function insert_item($data) {
        $this->db->insert('tbl_agent_liquidation_items', $data);
        return $this->db->insert_id();
    }

    public function get_notes($liq_ref) {
        $sql = "SELECT * FROM notes_master
                WHERE liq_ref = ?";
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