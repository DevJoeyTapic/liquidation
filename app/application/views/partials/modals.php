<!-- Modals -->
<?php if($this->session->userdata('user_type') == 2): ?>
    <div class="modal fade" id="multipleEntryModal" tabindex="-1" aria-labelledby="multipleEntryModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="multipleEntryModalLabel">Cost Breakdown</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <p class="label">ITEM NAME:</p>
                    <p class="title" id="itemName"></p>
                </div>
                <div class="mb-2 row">
                    <div class="col-auto">
                        <p class="label">RFP NO.:</p>
                        <p class="title" id="rfpNo"></p>
                    </div>
                    <div class="col-auto">
                        <p class="label">RFP AMOUNT:</p>
                        <p class="title" id="rfpAmt"></p>
                    </div>
                </div>
                <div class="row pe-3 d-flex justify-content-end align-items-center">
                    <button type="button" class="w-auto btn btn-primary btn-sm mb-2 add">Add Field</button>
                </div>
                <div class="addedFields">
                    <!-- added fields goes here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary submit" data-bs-dismiss="modal" id="submitBtn">Submit</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="itemSubmissionModal" tabindex="-1" aria-labelledby="itemSubmissionModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="itemSubmissionModalLabel">Add Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="user_id" value="<?= $item->user_id; ?>">
                <input type="hidden" name="supplier" value="<?= $item->supplier; ?>">
                <input type="hidden" name="transno" value="<?= $item->transno; ?>">
                <input type="hidden" name="isNew" value="1">
                <div class="row m-2">
                    <label for="itemName p-0">Item Name: </label>
                    <input type="text" class="form-control form-control-sm mb-2" id="newItem">
                </div>
                <div class="row m-2 gap-2">
                    <div class="col p-0">
                        <label for="currency">Currency: </label>
                        <select class="form-control form-control-sm mb-2" id="currency" name="currency">
                            <option value="USD">USD</option>
                            <option value="PHP">PHP</option>
                        </select>
                    </div>
                    <div class="col p-0">
                        <label for="amount">Amount: </label>
                        <input type="text" class="form-control form-control-sm mb-2" placeholder="0.00" id="newAmount">
                    </div>
                </div>
                <div class="row m-2">
                    <label for="itemName p-0">Remarks: </label>
                    <input type="text" class="form-control form-control-sm mb-2" id="remarks">
                </div>
                <div class="row m-2">
                    <label for="docref">Upload:</label>
                    <input type="file" class="form-control form-control-sm mb-2" name="filenames[]" multiple id="newUpload">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="addItem" data-bs-dismiss="modal">Add</button>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>



<?php if($this->session->userdata('user_type') != 1): ?>
    <div class="modal fade" id="showItemRemarksModal" tabindex="-1" aria-hidden="true" style="max-height: 500px !important;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title fs-5" id="showItemRemarksModalLabel">Variance Remarks</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-body">
            <input type="hidden" id="fullname" value="<?= $this->session->userdata('fullname') ?>">
            <p class="bold">Remarks: </p>
            <table class="table table-hover" id="remarksTable">
                <tbody>
                    <!-- item remarks goes here -->
                    
                </tbody>
            </table>
            <div id="scrollHere">

            </div>
        </div>
        <div class="modal-footer">

            <div class="input-group d-flex justify-content-betwen align-items-center">
                <input type="text" class="form-control" placeholder="Reply" id="newRemarkInput">
                <button class="btn btn-primary" id="addRemarkBtn">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if($this->session->userdata('user_type') == 2): ?>
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="dropZone">
                    <p>Drag & Drop files or click to choose files</p>
                    <button class="btn btn-sm btn-primary" id="chooseFilesButton"><i class="fa-solid fa-upload me-2"></i>Choose Files</button>
                    <input type="file" id="fileUpload" multiple />
                </div>
                <p class="bold my-3">Uploaded Files: </p>
                <ul id="fileNamesList" class="list-group mt-3"></ul>
                <div id="filePreview" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="uploadBtn">Upload</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
 <!-- add user modal -->
<?php if($this->session->userdata('user_type') == 1): ?>
    <div class="modal fade" id="addUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo base_url('admin/addUser');?>" method="POST">
                    <div class="modal-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <label for="username" class="small ms-2 mb-2">USERNAME</label>
                                    <input type="text" class="form-control mb-2" name="username" value="<?php echo set_value('name') ?>"required>
                                </div>
                                <div>
                                    <label for="password" class="small ms-2 mb-2">PASSWORD</label>
                                    <input type="password" class="form-control mb-2" name="password" value="<?php echo set_value('password') ?>" required>
                                </div>
                            </div>
                            <label for="fullname" class="small ms-2 mb-2">FULL NAME</label>
                            <input type="text" class="form-control mb-2" name="fullname" value="<?php echo set_value('fullname') ?>" required>

                            <label for="email" class="small ms-2 mb-2">EMAIL</label>
                            <input type="email" class="form-control mb-2" name="email" value="<?php echo set_value('email') ?>">

                            <label for="role" class="small ms-2 mb-2">ROLE</label>
                            <select class="form-select mb-3" name="user_type" id="user_type" required>
                                <option selected disabled></option>
                                <option value="1"  <?php echo (isset($users['user_type']) && $users['user_type'] == 1) ? 'selected' : ''; ?>>Admin</option>
                                <option value="2"  <?php echo (isset($users['user_type']) && $users['user_type'] == 2) ? 'selected' : ''; ?>>Agent</option>
                                <option value="3"  <?php echo (isset($users['user_type']) && $users['user_type'] == 3) ? 'selected' : ''; ?>>Accounting</option>
                                <option value="4"  <?php echo (isset($users['user_type']) && $users['user_type'] == 4) ? 'selected' : ''; ?>>TAD</option>
                            </select>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addUserBtn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 <!-- edit user modal -->
 <div class="modal fade" id="editUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo base_url('admin/updateUser');?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="username" class="small ms-2 mb-2">USERNAME</label>
                            <input type="text" class="form-control mb-2" name="username" id="usernametxt" required>
                        </div>
                        <div>
                            <label for="password" class="small ms-2 mb-2">PASSWORD</label>
                            <input type="password" class="form-control mb-2" name="password" id="passwordtxt">
                        </div>
                    </div>
                    <label for="fullname" class="small ms-2 mb-2">FULL NAME</label>
                    <input type="text" class="form-control mb-2" name="fullname" id="fullnametxt" required>

                    <label for="email" class="small ms-2 mb-2">EMAIL</label>
                    <input type="email" class="form-control mb-2" name="email" id="emailtxt">

                    <label for="role" class="small ms-2 mb-2">ROLE</label>
                    <select class="form-select mb-2" name="user_type" id="user_type" required>
                        <option value="0" selected disabled></option>
                        <option value="1"  <?php echo (isset($users['user_type']) && $users['user_type'] == 1) ? 'selected' : ''; ?>>Admin</option>
                        <option value="2"  <?php echo (isset($users['user_type']) && $users['user_type'] == 2) ? 'selected' : ''; ?>>Agent</option>
                        <option value="3"  <?php echo (isset($users['user_type']) && $users['user_type'] == 3) ? 'selected' : ''; ?>>Accounting</option>
                        <option value="4"  <?php echo (isset($users['user_type']) && $users['user_type'] == 4) ? 'selected' : ''; ?>>TAD</option>
                    </select>
                    <p class="small ms-2 text-warning">Marks the user as active. Uncheck this instead of deleting accounts.</p>

                    <div class="form-check ms-2">
                        <input type="checkbox" class="form-check-input" id="status" name="is_active">
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveEditBtn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
