
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Uploaded Document(s)</th>
                    </tr>
                </thead>   
                <tbody id="table-body">
<?php       foreach($uploads as $upload){
?>                  <tr>
                        <td>
                            <div class="file_item">
                                <form action="fileuploads/delete/<?=$upload['id'];?>" method="POST">
                                    <input  type="submit"  value="X" class="btn_delete">
                                </form>
                            </div>
                            <span> <?= $upload['file_description']; ?> </span>
                        </td>
                        <td>
<?php                       $fileUrl = 'uploads/'.$upload['file_name'];
                            $ext = $upload['file_type'];
                            if(in_array($ext,['jpg','png','jpeg','gif'])){
?>                              <img src="<?= base_url($fileUrl); ?>" alt="Preview" class="preview_image" data-src="<?= base_url($fileUrl); ?>">
<?php                       }
                            if ($ext === 'pdf'){
?>                              <canvas class="preview-pdf" data-src="<?= base_url($fileUrl); ?>"></canvas>
<?php                       }
?>                      </td>               
                    </tr>
<?php       }
?>              </tbody>
            </table>