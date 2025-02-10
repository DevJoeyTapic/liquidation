
<?php       if ($this->session->flashdata('error')){
?>              <div class="flash_message">
                    <?= $this->session->flashdata('error'); ?><span class="close_btn">&times;</span>
                    <?= $this->session->unset_userdata('error'); ?>
                </div>
<?php       }
?> 

