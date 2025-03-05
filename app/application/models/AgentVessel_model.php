<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgentVessel_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_liquidation_items($user_id, $id) {
        $sql = "SELECT 
                    i.*, 
                    l.`status` AS liq_status,
                    s.`status` AS desc_status,
                FROM tbl_agent_liquidation_items AS i
                INNER JOIN tbl_agent_liquidation AS l ON i.transno = l.transno
                INNER JOIN tbl_liq_item_status AS s ON i.`status` = s.id
                WHERE i.user_id = ? AND l.id = ? ";
        $query = $this->db->query($sql, array($user_id, $id));
        return $query->result();
    }
    public function get_for_am() {
        $sql = "SELECT
                    i.*,
                    s.`status` as desc_status
                FROM tbl_agent_liquidation_items AS i
                INNER JOIN tbl_liq_item_status AS s ON i.`status` = s.id
                WHERE i.`status` = 3";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function for_amendment_tad($data) {
        if (!empty($data['item_id'])) {
            $sql = "UPDATE tbl_agent_liquidation_items
                    SET `status` = 8
                    WHERE id = ?";
            $this->db->query($sql, array(
                $data['item_id']
            ));
        }
    }
    public function for_amendment_acctg($data) {
        if (!empty($data['item_id'])) {
            $sql = "UPDATE tbl_agent_liquidation_items
                    SET `status` = 7
                    WHERE id = ?";
            $this->db->query($sql, array(
                $data['item_id']
            ));
        }
    }
    public function ok_to_pay($data) {
        if (!empty($data['item_id'])) {
            $sql = "UPDATE tbl_agent_liquidation_items
                    SET `status` = 2,
                        tad_ts = NOW()
                    WHERE id = ?";
            $this->db->query($sql, array(
                $data['item_id']
            ));
        }
    }
    public function submit_to_am($data) {
        if (!empty($data['item_id'])) {
            $sql = "UPDATE tbl_agent_liquidation_items
                    SET `status` = 3,
                        acctg_ts = NOW()
                    WHERE id = ?";
            $this->db->query($sql, array(
                $data['item_id']
            ));
        }
    }
    public function pay_to_agent($data) {
        if (!empty($data['item_id'])) {
            $sql = "UPDATE tbl_agent_liquidation_items
                    SET `status` = 4,
                    amanager_ts = NOW()
                    WHERE id = ?";
            $this->db->query($sql, array(
                $data['item_id']
            ));
        }
    }
    public function return_to_apar($data) {
        if (!empty($data['item_id'])) {
            $sql = "UPDATE tbl_agent_liquidation_items
                    SET `status` = 5
                    WHERE id = ?";
            $this->db->query($sql, array(
                $data['item_id']
            ));
        }
    }
}


?>