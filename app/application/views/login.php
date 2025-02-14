<?php require_once(APPPATH . 'views/layout/head.php'); ?>
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
