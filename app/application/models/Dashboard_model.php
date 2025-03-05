<?php
class Dashboard_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    // Get dashboard data for agent
    public function get_unliquidatedAg($user_id) {
        $sql = "SELECT
                    l.*,
                    i.`status` AS item_status,
                    s.`status` AS desc_status
                FROM tbl_agent_liquidation AS l
                JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno and l.supplier = i.supplier
                JOIN tbl_liq_item_status AS s
                ON i.`status` = s.id
                WHERE l.user_id = ? AND i.`status` = 0
                AND EXISTS (
                SELECT 1
                FROM tbl_agent_liquidation_items AS sub_i
                WHERE l.supplier = sub_i.supplier
                )
                GROUP BY l.transno, l.voyno
                ORDER BY id desc";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }
    public function get_pendingValidationAg($user_id) {
        $sql = "SELECT
                    l.*, i.`status` AS item_status,
                    s.`status` AS desc_status
                FROM tbl_agent_liquidation AS l
                JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno and l.supplier = i.supplier
                JOIN tbl_liq_item_status AS s
                ON i.`status` = s.id
                WHERE l.user_id = ? AND i.`status` IN (1,2,3,5,6)
                AND EXISTS (
                SELECT 1
                FROM tbl_agent_liquidation_items AS sub_i
                WHERE l.supplier = sub_i.supplier
                )
                GROUP BY l.transno, l.voyno
                ORDER BY id desc";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }
    public function get_completedAg($user_id) {
        $sql = "SELECT
                    l.*, i.`status` AS item_status,
                    s.`status` AS desc_status
                FROM tbl_agent_liquidation AS l
                JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno and l.supplier = i.supplier
                JOIN tbl_liq_item_status AS s
                ON i.`status` = s.id
                WHERE l.user_id = ? AND i.`status` = 4
                AND EXISTS (
                SELECT 1
                FROM tbl_agent_liquidation_items AS sub_i
                WHERE l.supplier = sub_i.supplier
                )
                GROUP BY l.transno, l.voyno
                ORDER BY id desc";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }
    public function get_forAmendmentAg($user_id) {
        $sql = "SELECT
                    l.*, i.`status` AS item_status,
                    s.`status` AS desc_status
                FROM tbl_agent_liquidation AS l
                JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno and l.supplier = i.supplier
                JOIN tbl_liq_item_status AS s
                ON i.`status` = s.id
                WHERE l.user_id = ? AND i.`status` IN (7,8)
                AND EXISTS (
                SELECT 1
                FROM tbl_agent_liquidation_items AS sub_i
                WHERE l.supplier = sub_i.supplier
                )
                GROUP BY l.transno, l.voyno
                ORDER BY id desc";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }
    // Get dashboard data for TAD and Accounting
    public function get_unliquidated() {
        $sql = "SELECT
                    l.*,
                    i.`status` as item_status,
                    s.`status` as desc_status
                FROM tbl_agent_liquidation AS l
                INNER JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno
                JOIN tbl_liq_item_status AS s
                ON i.`status` = s.id
                WHERE (i.`status` = 0) AND l.`status` = 1
                GROUP BY l.transno, l.voyno
                ORDER BY id desc";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_completed() {
        $sql = "SELECT
                    l.*,
                    i.`status` as item_status,
                    s.`status` as desc_status
                FROM tbl_agent_liquidation AS l
                INNER JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno
                JOIN tbl_liq_item_status AS s
                ON i.`status` = s.id
                WHERE (i.`status` = 4) AND l.`status` = 1
                GROUP BY l.transno, l.voyno
                ORDER BY id desc";
        $query = $this->db->query($sql);
        return $query->result();
    }
    // Get dashboard data for TAD
    public function get_pendingOTP() {
        $sql = "SELECT
                    l.*,
                    i.`status` as item_status,
                    s.`status` as desc_status
                FROM tbl_agent_liquidation AS l
                INNER JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno
                JOIN tbl_liq_item_status AS s
                ON i.`status` = s.id
                WHERE (i.`status` = 1 or i.`status` = 2 or i.`status` = 3 or i.`status` = 5 or i.`status` = 6) AND l.`status` = 1
                GROUP BY l.transno, l.voyno
                ORDER BY id desc";
        $query = $this->db->query($sql);
        return $query->result();
    }
    // Get dashboard data for Accounting
    public function get_pendingValidationAcc() {
        $sql = "SELECT
                    l.*,
                    i.`status` as item_status,
                    s.`status` as desc_status
                FROM tbl_agent_liquidation AS l
                INNER JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno
                JOIN tbl_liq_item_status AS s
                ON i.`status` = s.id
                WHERE (i.`status` = 2) AND l.`status` = 1
                GROUP BY l.transno, l.voyno
                ORDER BY id desc";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_forAmendmentAcc() {
        $sql = "SELECT
                    l.*,
                    i.`status` as item_status,
                    s.`status` as desc_status
                FROM tbl_agent_liquidation AS l
                INNER JOIN tbl_agent_liquidation_items AS i
                ON l.transno = i.transno
                JOIN tbl_liq_item_status AS s
                ON i.`status` = s.id
                WHERE (i.`status` = 5 or i.`status` = 6 or i.`status` = 7 or i.`status` = 8) AND l.`status` = 1
                GROUP BY l.transno, l.voyno
                ORDER BY id desc";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
?>