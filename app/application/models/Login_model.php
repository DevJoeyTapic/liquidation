<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM user_account WHERE username = ? AND password = ?";
        $query = $this->db->query($sql, array($username, $password));

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }
    public function change_password($username, $password) {
        
    }
}
?>