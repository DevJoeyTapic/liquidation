<?php
    class Notes_model extends CI_Model {
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

        public function get_notes($liq_ref) {
            $sql = "SELECT * FROM notes_master
                    WHERE liq_ref = ?";
            $query = $this->db->query($sql, array($liq_ref));
            return $query->result();
        }
    }
?>