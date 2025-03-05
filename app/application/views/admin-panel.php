<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('layout/head'); ?>
<body>
    <div class="container-fluid">
    <?php $this->load->view('layout/header'); ?>
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
    <?php require_once('views/partials/modals.php'); ?>


</body>
</html>
