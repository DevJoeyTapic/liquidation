<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WALLEM - L1QUID8</title>
    <link rel="icon" type="image/png" href="images/liquidate.ico">

    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>  

    <!-- JS Files -->
    <script src="<?= base_url('assets/js/dataTable.js'); ?>"></script>
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- CSS files -->
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/liquidate-agent.css'); ?>">
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
                        <li><h6 class="dropdown-header"><?= $this->session->userdata('username') ?: 'Guest'; ?> - <?= $this->session->userdata('user_type') == 2 ? 'Supercargo Agent' : ($this->session->userdata('user_type') == 3 ? 'Accounting' : 'Unknown'); ?></h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button></li>
                        <li><a class="dropdown-item" href="<?= site_url('login/logout'); ?>">Signout</a></li>
                    </ul>
                </div>  
            </div>
        </nav>
        <div class="main-container bg-gradient">
            <div class="cont mb-3">
                <div class="row p-0">
                    <div class="col-3 d-flex justify-content-center align-items-center agent-section">
                        <div class="agent-img">
                            <img src="images/default_pic.png" alt="">
                        </div>
                        <div class="agent-name ps-3">
                            <h4>Irog M. Mariano</h4>
                            <p class="label">ATTENDING SUPERCARGO</p>
                        </div>
                    </div>
                    <div class="col-9 text-center my-3 vessel-section d-flex justify-content-between align-items-center">
                        <div class="col-3  gap-2 d-flex justify-content-center align-items-center">
                            <div class="">
                                <i class="fa-solid fa-ship fa-xl text-warning"></i>
                            </div>
                            <div class="col text-start mb-2">
                                <p class="label">VESSEL</p>
                                <p class="title">LPGC ORIENTAL DAWN</p>
                            </div>
                        </div>
                        <div class="gap-2 d-flex justify-content-center align-items-center">
                            <div class="">
                                <i class="fa-solid fa-anchor fa-xl text-info"></i>
                            </div>
                            <div class="col text-start mb-2">
                                <p class="label">VOYAGE</p>
                                <p class="title">V48</p>
                            </div>
                        </div>
                        <div class="gap-2 d-flex justify-content-center align-items-center">
                            <div class="">
                                <i class="fa-solid fa-water fa-xl text-primary"></i>
                            </div>
                            <div class="col text-start">
                                <p class="label">PORT</p>
                                <p class="title">Mariveles PNOC Terminal</p>
                            </div>
                        </div>
                        <div class="d-block justify-content-start align-items-center">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-2">
                                    <i class="fa-solid fa-clock fa-xl text-primary"></i>
                                </div>
                                <div class="col text-start">
                                    <p class="label">ARRIVAL</p>
                                    <p class="title">2024-Oct-10</p>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-2">
                                    <i class="fa-solid fa-clock fa-xl text-success"></i>
                                </div>
                                <div class="col text-start">
                                    <p class="label">DEPARTURE</p>
                                    <p class="title">2024-Oct-11</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="cont">
                    <div class="row d-flex justify-content-center align-items-center dtTitle">
                        <h5 class="col mb-2">Vessel Liquidation</h5>
                        <p class="col label text-end">LIQUIDATION NO: <span class="text-danger">001</span></p>
                    </div>
                    <nav>
                        <div class="nav nav-tabs liquidation-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="pendingTab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true"><i class="fa-regular fa-clock pe-2"></i>Pending Item(s) Liquidation</button>    
                            <button class="nav-link" id="validatedTab" data-bs-toggle="tab" data-bs-target="#validated" type="button" role="tab" aria-controls="validated" aria-selected="false"><i class="fa-solid fa-circle-check pe-2"></i>Validated Item(s) Liquidation</button>            
                        </div>
                    </nav>
                    
                    <div class="tab-content" id="nav-tabContent">          
                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pendingTab">
                            <div class="row d-flex justify-content-end align-items-center">
                                <div class="col-lg-5 col-md-12 col-sm-12 ">
                                    <div class="alert alert-warning" role="alert">
                                        <div class="row">
                                            <div class="col">
                                                <p class="text-end bold">Total Debit Amount: </p>
                                                <p class="text-end bold">Total Credited Amount: </p>
                                            </div>
                                            <div class="col">
                                                <p>PHP 150,000.00</p>
                                                <p>PHP 120,000.00</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col">
                                                <p class="text-end bold">Credit Balance:  </p>
                                            </div>
                                            <div class="col">
                                                <p>PHP 30,000.00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-2"> 
                                <div class="data-table">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover display" id="dataTable3">
                                            <thead>
                                                <tr>
                                                    <th class="col-2">Item Name</th>
                                                    <th class="col-1 text-center">RFP No.</th>
                                                    <th class="col-2 text-center">Debit</th>
                                                    <th class="col-2">Credit</th>
                                                    <th class="col-2">Remarks</th>
                                                    <th class="col-2 text-center">Document Reference</th>
                                                    <th class="col-1 text-center">Validate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td>ARE | Agency Representative Expenses <span class="badge rounded-pill text-bg-warning">Controlled</span></td>
                                                <td class="text-center">6145</td>
                                                <td id="debit"><span class="label text-dark">PHP </span>36,000.00</td>
                                                <td id="credit"><span class="label text-dark">PHP </span>36,000.00</td>
                                                <td>partial</td>
                                                <td><a href="#">attach.pdf</a></td>
                                                <td><input type="checkbox" class="form-check-input"></td>
                                            </tbody>
                                        </table>
                                    </div>    
                                </div>
                                <div class="row mt-3">
                                    <div class="col d-flex gap-2 justify-content-end align-items-end">
                                        <button class="btn btn-success" data-bs-toggle="modal" id="validateAllBtn">
                                            Check All
                                        </button>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal" id="confirmValidation">
                                            Confirm
                                        </button>
                                    </div>
                                </div>                
                            </div>
                        </div>
                        <div class="tab-pane fade" id="validated" role="tabpanel" aria-labelledby="validatedTab">
                            <div class="d-flex justify-content-end">
                                <button class="btn text-primary">
                                    <i class="fa-solid fa-print pe-2"></i>Print Summary of Vessel Liquidation
                                </button>
                            </div>
                            <div class="row m-2">
                                <div class="data-table">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover display" id="dataTable4">
                                            <thead>
                                                <tr>
                                                    <th class="col-2">Item Name</th>
                                                    <th class="col-1 text-center">RFP No.</th>
                                                    <th class="col-2 text-center">RFP Amount</th>
                                                    <th class="col-2">Actual Amount</th>
                                                    <th class="col-2">Remarks</th>
                                                    <th class="col-2 text-center">Document Reference</th>
                                                    <th class="col-1 text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr></tr>
                                            </tbody>
                                        </table>
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="confirmationModalLabel">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    The item(s) will be moved to validated items liquidation. Do you want to proceed?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmMove">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#validateAllBtn').on('click', function() {
            $('.form-check-input').each(function() {
                $(this).prop('checked', !$(this).prop('checked'));
            });
        });
    </script>
</body>
</html>
