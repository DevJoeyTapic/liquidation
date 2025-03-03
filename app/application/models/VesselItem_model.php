<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VesselItem_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_liquidation_items($user_id, $id) {
        $sql = "SELECT 
                    i.*, 
                    l.`status` AS liq_status,
                    s.`status` AS desc_status
                FROM tbl_agent_liquidation_items AS i
                INNER JOIN tbl_agent_liquidation AS l ON i.transno = l.transno
                INNER JOIN tbl_liq_item_status AS s ON i.`status` = s.id
                WHERE i.user_id = ? AND l.id = ?
                ORDER BY i.id asc";
        $query = $this->db->query($sql, array($user_id, $id));
        return $query->result();
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
}

?>