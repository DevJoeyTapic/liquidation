<?php
class FileUploadController extends CI_Controller {

    public function upload() {
        // Load the file upload library
        $this->load->library('upload');
        
        // Set upload configuration
        $config['upload_path'] = './uploads/';  // Directory where files will be stored
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';  // Allowed file types
        $config['max_size'] = 2048;  // Max file size in KB
        $config['file_name'] = uniqid();  // Unique file name
        
        $this->upload->initialize($config);

        if ($this->upload->do_upload('userfile')) {
            $data = $this->upload->data();
            $filePath = base_url('uploads/') . $data['file_name'];  

            echo 'File uploaded successfully!';
            echo '<br>File Path: ' . $filePath;
        } else {
            // Error occurred during upload
            $error = $this->upload->display_errors();
            echo 'Error: ' . $error;
        }
    }
}
?>
