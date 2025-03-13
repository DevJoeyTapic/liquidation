<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function login($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('user_account');
    
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false; 
        }
    }
    

}
?>