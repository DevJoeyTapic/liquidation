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
        $sql = "SELECT l.*, i.`status` AS item_status, DATEDIFF(NOW(), l.etd) AS age
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
    public function get_vessel_items($transno, $supplier) {
        $sql = "SELECT
                    i.*,
                    s.`status` AS desc_status,
                    ROUND(
                        CASE
                            WHEN actual_amount > rfp_amount THEN
                                ((actual_amount - rfp_amount) / rfp_amount) * 100
                            WHEN actual_amount < rfp_amount THEN
                                ((rfp_amount - actual_amount) / rfp_amount) * 100
                            ELSE 
                                0
                        END, 2) AS variance_percent
                FROM tbl_agent_liquidation_items AS i
                INNER JOIN tbl_liq_item_status AS s ON i.`status` = s.id
                WHERE i.transno = ? AND i.supplier = ?
                ORDER BY id ASC";
        $query = $this->db->query($sql, array($transno, $supplier));
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

    public function get_total_amount($id) {
        $sql = 'SELECT
                i.`status`,
                i.controlled,
                i.currency,
                SUM(i.rfp_amount) AS `total_requested`,
                CASE 
                WHEN i.controlled = 0 THEN 0.00
                ELSE SUM(i.actual_amount) 
                END AS `total_received`,
                SUM(i.actual_amount) AS `total_actual`,
                SUM(i.variance) AS `total_variance`
                FROM tbl_agent_liquidation l
                JOIN tbl_agent_liquidation_items i
                ON l.transno = i.transno
                WHERE l.id = 131 AND (i.status IN (2,4))
                GROUP BY i.currency, i.`status`';
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    public function get_total_controlled($id) {
        $sql = 'SELECT
                i.`status`,
                i.controlled,
                i.currency,
                SUM(i.rfp_amount) AS `total_requested`,
                CASE 
                WHEN i.controlled = 0 THEN 0.00
                ELSE SUM(i.actual_amount) 
                END AS `total_received`,
                SUM(i.actual_amount) AS `total_actual`,
                SUM(i.variance) AS `total_variance`
                FROM tbl_agent_liquidation l
                JOIN tbl_agent_liquidation_items i
                ON l.transno = i.transno
                WHERE l.id = 131 AND (i.status IN (2,4))
                GROUP BY i.currency, i.`status`';
        $query = $this->db->query($sql, array($id));
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
    
    public function delete_item($id) {
        $sql = "DELETE FROM tbl_agent_liquidation_items WHERE id = ?";
        $this->db->query($sql, array($id)); 
        return $this->db->affected_rows() > 0; 
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