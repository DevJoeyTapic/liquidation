<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALS - Login</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/liquidate.ico'); ?>">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css'); ?>">

    <!-- Swal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card shadow-sm rounded-4 p-5">
                    <div class="text-center">
                        <img src="<?= base_url('assets/images/default_pic.png'); ?>" alt="Logo" class="mb-2" style="max-width: 80px;">
                        <h3 class="mb-3">SUPERCARGO LIQUIDATION</h3>
                    </div>
                    
                    <form action="<?= site_url('login/authenticate'); ?>" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Enter your username" required>
                            <label for="username" id="username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                            <label for="password" id="password">Password</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <!-- Footer Text -->
                    <div class="text-center mt-3">
                        <p class="text-muted" style="font-size: 0.9rem;">Made by Wallem Philippines</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Swal -->
    <?php if ($this->session->flashdata('error')): ?>
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
