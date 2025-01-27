<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_users() {
        $sql = "SELECT * FROM user_account";
        $query = $this->db->query($sql);
        return $query->result();
    
    }

    public function add_user($data) {
        return $this->db->insert('user_account', $data);
        echo 'User added successfully';
    }

    public function update_user($userId, $data) {
        $this->db->where('user_id', $userId);
        return $this->db->update('user_account', $data);
    }

    public function change_password($user_id, $new_password) {
        $data = array(
            'password' => md5($new_password)
        );
        $this->db->where('user_id', $user_id);
        return $this->db->update('user_account', $data);
    }

}
?>