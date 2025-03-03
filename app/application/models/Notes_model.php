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

        public function insert_notes($data) {
            $this->db->insert('notes_master', $data);
            return $this->db->insert_id();
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