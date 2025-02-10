<?php

class FileUpload extends CI_Model{

    public function get_all_Uploads(){
        return $this->db->query("SELECT id,file_description,file_name,file_type FROM upload")->result_array();
    }

    public function get_by_id_Upload($upload_id){
        return $this->db->query("SELECT file_name FROM upload WHERE id=?",array($upload_id))->row_array();
    }

    public function remove_Upload($upload_id){
        $file_name = $this->get_by_id_Upload($upload_id);

        if($file_name){
            $file_path = './uploads/'.implode($file_name);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            return $this->db->query("DELETE FROM upload WHERE id=?",array($upload_id));
        }
        return false;
    }
 
    public function save_Upload($data){
        $sql = "INSERT INTO upload(file_name,file_description,file_type,created_at) VALUES(?,?,?,?)";
        $values= array($data['file_name'],$data['file_description'],explode("/",$data['file_type'],2)[1], date("Y-m-d, H:i:s"));
        return $this->db->query($sql,$values);
    }

    public function update_Description($id, $description) {
        $sql = "UPDATE upload SET description = ? WHERE id = ?";
        return $this->db->query($sql, [$description, $id]);
    }
}
?>