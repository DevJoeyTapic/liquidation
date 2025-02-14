<?php require_once(APPPATH . 'views/layout/head.php'); ?>
<body>
    <div class="container-fluid">
        <?php require_once(APPPATH . 'views/layout/header.php'); ?>

        <div class="main-container bg-gradient mt-5">
            <h3 class="my-3">Site Administrator</h3>
            <div class="accordion" id="user-accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <strong>User Management</strong>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#user-accordion">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="fa-solid fa-user pe-2"></i>New User
                            </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover" id="tableUsers">
                                    <thead>
                                        <tr>
                                            <th class="text-end">#</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th class="text-center">Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $row = 0; foreach($users as $user): ?>
                                            <tr>
                                                <th class="text-end">
                                                    <?= ++$row ?>.
                                                    <input type="hidden" name="user_id" value="<?= $user->user_id; ?>">
                                                    <input type="hidden" name="status" value="<?= $user->is_active; ?>">
                                                </th>
                                                <td class="username"><?= $user->username; ?></td>
                                                <td class="password"><?= $user->password; ?></td>
                                                <td class="fullname"><?= $user->fullname; ?></td>
                                                <td class="email"><?= $user->email; ?></td>
                                                <td class="user_type"><?= $user->user_type == 1 ? 'Admin' : ($user->user_type == 2 ? 'Agent' : ($user->user_type == 3 ? 'Accounting' : 'TAD')); ?></td>
                                                <td class="text-center status"><?= $user->is_active == 1 ? '<i class="fa-solid fa-circle-check text-success"></i>' : '<i class="fa-solid fa-circle-xmark text-danger"></i>'; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm text-primary" data-bs-toggle="modal" data-bs-target="#editUserModal" id="updateUserBtn">
                                                        <i class="fa-regular fa-lg fa-pen-to-square" ></i>
                                                    </button>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
 <!-- add user modal -->
    <div class="modal fade" id="addUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo site_url('admin/addUser');?>" method="POST">
                    <div class="modal-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <label for="username" class="small ms-2 mb-2">USERNAME</label>
                                    <input type="text" class="form-control mb-2" name="username" value="<?php echo set_value('name') ?>"required>
                                </div>
                                <div>
                                    <label for="password" class="small ms-2 mb-2">PASSWORD</label>
                                    <input type="text" class="form-control mb-2" name="password" value="<?php echo set_value('password') ?>" required>
                                </div>
                            </div>
                            <label for="fullname" class="small ms-2 mb-2">FULL NAME</label>
                            <input type="text" class="form-control mb-2" name="fullname" value="<?php echo set_value('fullname') ?>" required>

                            <label for="email" class="small ms-2 mb-2">EMAIL</label>
                            <input type="email" class="form-control mb-2" name="email" value="<?php echo set_value('email') ?>" required>

                            <label for="role" class="small ms-2 mb-2">ROLE</label>
                            <select class="form-select mb-3" name="user_type" id="user_type" required>
                                <option selected disabled></option>
                                <option value="1"  <?php echo ($user->user_type == 1) ? 'selected' : ''; ?>>Admin</option>
                                <option value="2"  <?php echo ($user->user_type == 2) ? 'selected' : ''; ?>>Agent</option>
                                <option value="3"  <?php echo ($user->user_type == 3) ? 'selected' : ''; ?>>Accounting</option>
                                <option value="4"  <?php echo ($user->user_type == 4) ? 'selected' : ''; ?>>TAD</option>
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
                <form action="<?php echo site_url('admin/updateUser');?>" method="POST">
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
                        <input type="email" class="form-control mb-2" name="email" id="emailtxt" required>

                        <label for="role" class="small ms-2 mb-2">ROLE</label>
                        <select class="form-select mb-2" name="user_type" id="user_type" required>
                            <option value="0" selected disabled></option>
                            <option value="1"  <?php echo ($user->user_type == 1) ? 'selected' : ''; ?>>Admin</option>
                            <option value="2"  <?php echo ($user->user_type == 2) ? 'selected' : ''; ?>>Agent</option>
                            <option value="3"  <?php echo ($user->user_type == 3) ? 'selected' : ''; ?>>Accounting</option>
                            <option value="4"  <?php echo ($user->user_type == 4) ? 'selected' : ''; ?>>TAD</option>
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
    <!-- Swal Alert -->
    <?php if ($this->session->flashdata('success')): ?>
        <script>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo $this->session->flashdata('success'); ?>',
                icon: 'success',
                confirmButtonText: 'Awesome!'
            }).then(function() {
                <?php $this->session->unset_userdata('success'); ?>
            });
        </script>
    <?php elseif ($this->session->flashdata('error')): ?>
        <script>
            Swal.fire({
                title: 'Error!',
                text: '<?php echo $this->session->flashdata('error'); ?>',
                icon: 'error',
                confirmButtonText: 'Try Again'
            }).then(function() {
                <?php $this->session->unset_userdata('error'); ?>
            });
        </script>
    <?php endif; ?>

</body>
</html>
