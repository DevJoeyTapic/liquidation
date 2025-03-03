<?php
class Liquidation_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_for_validation() {
        $sql = "SELECT
                    l.id,
                    l.user_id,
                    l.supplier,
                    l.transno,
                    l.vessel_name,
                    l.voyno,
                    l.`port`,
                    l.`status`,
                    i.`status` as item_status
                FROM tbl_agent_liquidation AS l
                INNER JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno
                WHERE (i.`status` = 0 or i.`status` = 1 or i.`status` = 2 or i.`status` = 3 or i.`status` = 4 or i.`status` = 5) AND l.`status` = 1
                GROUP BY l.transno, l.voyno";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_agent_liquidations($user_id) {
        $sql = "SELECT * 
                FROM tbl_agent_liquidation l
                WHERE l.user_id = ?
                AND EXISTS (
                    SELECT 1 
                    FROM tbl_agent_liquidation_items i
                    WHERE l.transno = i.transno AND l.supplier = i.supplier
                );
                ";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }
    public function get_vessel_data($id) {
        $sql = "SELECT l.*, i.`status` AS item_status
                FROM tbl_agent_liquidation AS l
                JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno
                WHERE l.id = ?";
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
        $sql = "SELECT
                    i.*,
                    s.`status` AS desc_status
                FROM tbl_agent_liquidation_items AS i
                INNER JOIN tbl_liq_item_status AS s ON i.`status` = s.id
                WHERE transno = ?
                ORDER BY id ASC";
        $query = $this->db->query($sql, array($transno));
        return $query->result();
    }
    
    public function get_liquidation_item($user_id, $id) {
        $sql = "SELECT 
                    i.*,
                    l.`status` AS liqStatus
                FROM tbl_agent_liquidation_items AS i
                -- INNER JOIN liquidation_item_status AS s ON i.status = s.status
                INNER JOIN tbl_agent_liquidation AS l ON i.transno = l.transno
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

    public function update_item_agent($data) {
        if (!empty($data['actualAmount']) && !empty($data['variance']) && !empty($data['item_id'])) {
            $sql = "UPDATE tbl_agent_liquidation_items
                    SET `status` = 1,
                        actual_amount = ?,
                        variance = ?
                    WHERE id = ?";
            $this->db->query($sql, array(
                $data['actualAmount'],
                $data['variance'],
                $data['item_id']
            ));
        }
    }

    public function revalidate_item($id) {
        $sql ="UPDATE tbl_agent_liquidation_items
               SET `status` = 5
               WHERE id = ?";
        $this->db->query($sql, array($id));
    }

    public function update_item_by_acctg($id) {
        $sql ="UPDATE tbl_agent_liquidation_items
               SET `status` = 3
               WHERE id = ?";
        $this->db->query($sql, array($id));
    }

    public function get_item_remarks($item_id) {
        $sql = "SELECT * FROM tbl_remarks
                WHERE item_id = ?";
        $query = $this->db->query($sql, array($item_id));
        return $query->result();
    }

    public function insert_item_remark($data) {
        $this->db->insert('tbl_remarks', $data);
        return $this->db->insert_id();
    }

    public function add_breakdown_cost($data) {
        $this->db->insert('tbl_item_breakdown', $data);
        return $this->db->insert_id();
    }




    


    
}
?>