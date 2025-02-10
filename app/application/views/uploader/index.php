<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Uploader</title>
    <link rel="stylesheet" href="<?=base_url('assets/css/upload.css');?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js"></script>    
    <script src="<?=base_url('assets/js/upload.js');?>"></script>
</head>
<body>
    <div class="container">
        <div class="uploads">
            <h1>Upload Document</h1>
            <!-- Flash Messages -->
            <div id="flash-message-container">
<?php            $this->load->view('partials/flash_message'); 
?>          </div>
            <div>
                <form id="uploadForm" action="fileuploads/file_upload" method="post" enctype="multipart/form-data">
                    <div>
                        <input type="file" class="btn_up" name="userfile[]" accept=".jpg,.jpeg ,gif, .png, .pdf" multiple>
                        <input type="submit" name="btn_submit" value="Upload" class="btn"> 
                    </div> 
                    <div id="spinner" style="display: none; text-align: center; margin-top: 10px;">
                        <div class="loader"></div>
                        <p>Uploading, please wait...</p>
                    </div>
                </form>
            </div>
        </div>
        <div class="uploads">
            <!-- Uploaded Files Table -->
            <div id="uploaded-files-container">
                <?php $this->load->view('partials/uploaded_files', ['uploads' => $uploads]); ?>
            </div>
        </div>
    </div>

    <!-- Modal for Image and PDF -->
    <div id="file-modal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modal-img" style="display: none;">
        <iframe class="modal-content" id="modal-pdf" style="display: none; width: 90%; height: 90vh;" frameborder="0"></iframe>
    </div>
</body>
</html>