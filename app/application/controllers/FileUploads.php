<?php

class FileUploads extends CI_Controller{

    public function index(){
        $this->load->model('FileUpload');
        $data['uploads'] = $this->FileUpload->get_all_Uploads();
        $this->load->view('uploader/index',$data);
    }

    public function file_upload(){
        
        // Load the Upload Library
        $this->load->library('upload');

        // Upload configuration
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $config['max_size']      = 15360;
        $config['encrypt_name']  = TRUE;
         // Initialize the Upload Library with the config
        $this->upload->initialize($config);

        $files = $_FILES;
        $count = count($_FILES['userfile']['name']);
        $uploadData = [];
        // echo '<pre>';
        // var_dump($files['userfile']);
        // echo '</pre>';

        for($i=0;$i<$count;$i++){
            $_FILES['userfile'] = [
                'name' => $files['userfile']['name'][$i],
                'type' => $files['userfile']['type'][$i],
                'tmp_name' => $files['userfile']['tmp_name'][$i],
                'error' => $files['userfile']['error'][$i],
                'size' => $files['userfile']['size'][$i],
            ];

            if ($this->upload->do_upload('userfile')) {
                $filedata = $this->upload->data();
                $this->load->model('FileUpload');
                $this->FileUpload->save_Upload([
                     'file_name' => $filedata['file_name'],
                     'file_description' => $filedata['orig_name'],
                     'file_type' => $filedata['file_type'],
                ]);
            }
            else {
                $filedata['error'] = $this->upload->display_errors();
                $this->session->set_flashdata('error',implode($filedata));
                // redirect('/');
            }

        }
        redirect('/fileuploads');
    }

    public function delete($str){
        $this->load->model('FileUpload');
        $this->FileUpload->remove_Upload($str);
        redirect('/');
     }

     public function flash_messages() {
        $this->load->view('partials/flash_message');
    }

    public function refresh_uploaded_files() {
        $data['uploads'] = $this->FileUpload->get_all_Uploads();
        $this->load->view('uploader/index',$data);
    }

}

?>