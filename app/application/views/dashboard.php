<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALS - Dashboard</title>
    <link rel="icon" type="image/png" href="images/liquidate.ico">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      
    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <!-- JS Files -->
    <script src="<?= base_url('assets/js/dataTable.js') ?>"></script>


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- CSS files -->
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css'); ?>">

</head>
<body>
    <div class="container-fluid">
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
                        <li>
                            <h6 class="dropdown-header">
                                <?= $this->session->userdata('username') ?: 'Guest'; ?> - 
                                <?php 
                                    switch ($this->session->userdata('user_type')) {
                                        case 1:
                                            echo 'Admin';
                                            break;
                                        case 2:
                                            echo 'Supercargo Agent';
                                            break;
                                        case 3:
                                            echo 'Accounting';
                                            break;
                                        default:
                                            echo 'Unknown';
                                            break;
                                    }
                                ?>
                            </h6>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button></li>
                        <li><a class="dropdown-item" href="<?= site_url('login/logout'); ?>">Signout</a></li>
                    </ul>
                </div>  
            </div>
        </nav>
        <div class="main-container bg-gradient">
            <!-- ALERT FOR SUPERCARGO AGENT ONLY -->
            <?php if($this->session->userdata('user_type') == 2): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="fa-solid fa-exclamation-circle me-3"></i>
                    <?php
                        date_default_timezone_set('Asia/Singapore'); 
                    ?>
                    <div>
                        <strong>Due Wallem: </strong> PHP 39,377.01
                        <p class="small"><?php echo "As of " . date('F j, Y H:i A'); ?></p>

                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <div class="dashboard-logo">
                <img src="<?= base_url('assets/images/wallem_no_bg.png'); ?>" alt="Wallem Logo">
            </div>
            <div class="search-section" id="dataTable_filter">
                <input type="text" id="dataSearch" class="form-control form-control-sm search-bar" placeholder="Search keywords" autofocus>
            </div>
            <div class="search-result cont d-flex flex-column">
                <div class="data-table">
                    <!-- table view for accounting -->
                    <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                        <table class="table table-hover table-striped" id="dataTable5">
                            <thead>
                                <tr>
                                    <th>Agent</th>
                                    <th>Liquidation No.</th>
                                    <th>Vessel</th>
                                    <th>Voyage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accounting_liquidations as $liquidation): ?>
                                    <tr onclick="window.location.href='<?= site_url('agentvessel'); ?>'">
                                        <td><?= $liquidation->agent_name; ?></td>
                                        <td><?= $liquidation->liquidation_no; ?></td>
                                        <td><?= $liquidation->vessel; ?></td>
                                        <td><?= $liquidation->voyage; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- table view for supercargo agent -->
                    <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 2) ? 'block' : 'none'; ?>">
                        <table class="table table-hover display" id="dataTable1">
                            <thead>
                                <tr>
                                    <th>Vessel</th>
                                    <th>Voyage</th>
                                    <th>Port</th>
                                    <th>Arrival</th>
                                    <th>Departure</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($agent_liquidations as $liquidation): ?>
                                    <tr onclick="window.location.href='<?= site_url('vesselitem/view/' . str_replace(' ', '', $liquidation->vessel) . '/' . urlencode($liquidation->voyage)); ?>'">
                                        <td><?= $liquidation->vessel; ?></td>
                                        <td><?= $liquidation->voyage; ?></td>
                                        <td><?= $liquidation->port; ?></td>
                                        <td><?= $liquidation->eta; ?></td>
                                        <td><?= $liquidation->etd; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="changePasswordModalLabel">Change Your Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="currentUserPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentUserPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="newUserPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newUserPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmUserPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmUserPassword" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Update Password</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
