<?php
class Breakdown_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function add_breakdown_cost($data) {
        $this->db->insert('tbl_item_breakdown_temp ', $data);
        return $this->db->insert_id();
    }

    public function get_breakdown_cost($item_id) { 
        $sql = 'SELECT * FROM tbl_item_breakdown    
                WHERE item_id
                IN ?';
        $query = $this->db->query($sql, array($item_id));
        return $query->result_array();
    }
}