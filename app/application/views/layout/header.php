<nav class="navbar fixed-top bg-gradient">
    <div class="d-flex justify-content-center align-items-center">
        <a href="<?= base_url() ?>"><img src="<?= base_url('assets/images/wallem_logo_white.png'); ?>" class="header-logo"> </a>
    </div>

    <div class="profile">
        <div class="btn-group">
            <button type="button" class="btn text-white dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                <img src="<?= base_url('assets/images/default_pic.png'); ?>">
            </button>
            
            <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header"><?= $this->session->userdata('fullname') ?: 'Guest'; ?></h6></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?= site_url('login/logout'); ?>">Signout</a></li>
            </ul>
        </div>  
    </div>
</nav>