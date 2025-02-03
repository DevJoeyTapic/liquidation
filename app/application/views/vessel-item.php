<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALS</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/liquidate.ico'); ?>">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      
    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- CSS files -->
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css'); ?>">

    <!-- Swal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JS Files -->
    <script src="<?= base_url('assets/js/dataTable.js'); ?>"></script>
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>





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
                        <li><h6 class="dropdown-header"><?= $this->session->userdata('fullname') ?: 'Guest'; ?> - <?= $this->session->userdata('user_type') == 2 ? 'Supercargo Agent' : ($this->session->userdata('user_type') == 3 ? 'Accounting' : 'Unknown'); ?></h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= site_url('login/logout'); ?>">Signout</a></li>
                    </ul>
                </div>  
            </div>
        </nav>

        <div class="main-container bg-gradient">
            <div class="cont mb-3">
                <div class="row px-3 d-flex justify-content-start align-items-center">
                    <?php if (!empty($vessel_data)): ?>
                        <div class="col p-0">
                            <div class="row p-0 d-flex justify-content-start align-items-center">
                                <div class="col-2">
                                    <i class="fa-solid fa-ship fa-xl text-warning"></i>
                                </div>
                                <div class="col-10">
                                    <p class="label">VESSEL</p>
                                    <p class="title"><?= $vessel_data[0]->vessel_name; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 p-0">
                            <div class="row p-0 d-flex justify-content-start align-items-center">
                                <div class="col-3">
                                    <i class="fa-solid fa-anchor fa-xl text-info"></i>
                                </div>
                                <div class="col-9">
                                    <p class="label">VOYAGE</p>
                                    <p class="title"><?= $vessel_data[0]->voyno; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col p-0">
                            <div class="row p-0 d-flex justify-content-start align-items-center">
                                <div class="col-2">
                                    <i class="fa-solid fa-water fa-xl text-primary"></i>
                                </div>
                                <div class="col-10">
                                    <p class="label">PORT</p>
                                    <p class="title"><?= $vessel_data[0]->port; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 p-0">
                            <div class="row d-flex justify-content-start align-items-center">
                                <div class="col-2">
                                    <i class="fa-solid fa-clock fa-xl text-primary"></i>
                                </div>
                                <div class="col-10">
                                    <p class="label">ARRIVAL</p>
                                    <p class="title"><?= $vessel_data[0]->eta; ?></p>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-start align-items-center">
                                <div class="col-2">
                                    <i class="fa-solid fa-clock fa-xl text-success"></i>
                                </div>
                                <div class="col-10">
                                    <p class="label">DEPARTURE</p>
                                    <p class="title"><?= $vessel_data[0]->etd; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="cont mb-3">
                <h5 class="mb-3">Liquidation Overview</h5>
                <?php 
                    $count = 0;
                    $liquidated = 0;
                    $remaining = 0;
                    foreach ($liquidation_item as $item): 
                        $status = (int)$item->status;

                        if ($item->user_id == $this->session->userdata('user_id')): 
                            $count++;
                        endif;
                        if ($status == 3):
                            $liquidated++;
                            
                        endif;
                        if ($status != 3):
                            $remaining++;
                        endif;
                    endforeach;
                    $liqpercent = ($liquidated/$count) * 100;
                    $remainingP = ($remaining/$count) * 100;
                ?>
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $liqpercent; ?>%" aria-valuenow="<?= $liqpercent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $remainingP; ?>%" aria-valuenow="<?= $remainingP; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>


                <div class="legend mt-2">
                    <ul class="list-unstyled">
                    <?php 
                        $count = 0;
                        $liquidated = 0;
                        $remaining = 0;
                        foreach ($liquidation_item as $item): 
                            $status = (int)$item->status;

                            if ($item->user_id == $this->session->userdata('user_id')): 
                                $count++;
                            endif;
                            if ($status == 3):
                                $liquidated++;
                                
                            endif;
                            if ($status != 3):
                                $remaining++;
                            endif;
                        endforeach;
                        $liqpercent = intval(($liquidated / $count) * 100);
                        $remainingP = intval(($remaining / $count) * 100);

                    ?>
                        <li class="mb-2"><strong>Total No. of Items: <?= $count; ?></strong></li>
                        <li><span class="progress-bar progress-bar-legend bg-primary"></span>Liquidated Items: <?= $liqpercent; ?>% (<?= $liquidated; ?> of <?= $count ?>)</li>
                        <li><span class="progress-bar progress-bar-legend bg-danger"></span>Remaining Items: <?= $remainingP; ?>% (<?= $remaining; ?> of <?= $count ?>)</li>
                    </ul>
                </div>
                <?php if (!empty($agent_liquidations)): ?>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success btn-sm" id="markComplete" <?= ($liqpercent == 100) ? '' : 'disabled' ?>> <i class="fa-solid fa-check pe-2"></i>Mark as Complete</button>
                    </div>
                <?php endif ?>

            </div>

            <div class="cont">
                <h5 class="mb-3">Item Liquidation</h5>
                <nav>
                    <div class="nav nav-tabs liquidation-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="pendingTab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true"><i class="fa-regular fa-clock pe-2"></i>Pending Item(s) Liquidation</button>    
                        <button class="nav-link" id="forValidationTab" data-bs-toggle="tab" data-bs-target="#forValidation" type="button" role="tab" aria-controls="forValidation" aria-selected="false"><i class="fa-solid fa-user-clock pe-2"></i>Liquidated Item(s) for Validation</button>
                        <button class="nav-link" id="validatedTab" data-bs-toggle="tab" data-bs-target="#validated" type="button" role="tab" aria-controls="validated" aria-selected="false"><i class="fa-solid fa-circle-check pe-2"></i>Liquidated Item(s)</button>            
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pendingTab">
                        <div class="row m-2"> 
                            <div class="data-table">
                                <div class="d-flex justify-content-end mb-2">
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemSubmissionModal">
                                        <i class="fa-solid fa-plus"></i>
                                        Add Item
                                    </button>
                                </div>
                                <div class="table-reponsive">
                                    <table class="table table-hover display" id="dataTable2">
                                        <thead>
                                            <tr>
                                                <th class="col-3">Items</th>
                                                <th class="col">Description</th>
                                                <th class="col-1 text-center">RFP No.</th>
                                                <th class="col-2">RFP Amount</th>
                                                <th class="col-2">Actual Amount</th>
                                                <th class="col-2">Variance</th>
                                                <th class="col-2">Remarks</th>
                                                <th class="col-2 text-center">Document Reference</th>
                                                <th class="col">Validate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($liquidation_item as $item): ?>
                                                <?php if ($item->user_id == $this->session->userdata('user_id') && $item->status == '0'): ?>
                                                    <tr>
                                                        <td class="col-3" id="item">
                                                            <?= $item->item; ?>
                                                            <?php if($item->controlled == 0): ?>
                                                                <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="col" id="description"></td>
                                                        <td class="col-1 text-center" id="rfpno">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <span class="badge text-bg-primary">NEW ITEM</span>
                                                            <?php else: ?>  
                                                                <?= $item->rfp_no; ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="col-2 rfpAmount" id="rfpAmount">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <span class="badge text-bg-primary">NEW ITEM</span>
                                                            <?php else: ?>  
                                                                <?= number_format($item->rfp_amount, 2); ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="col-2 text-end">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" value="<?= $item->actual_amount; ?>" disabled>
                                                            <?php else: ?>  
                                                                <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" value="<?= $item->actual_amount; ?>" required>
                                                                <button class="btn btn-sm text-primary multiple-btn" data-bs-toggle="modal" data-bs-target="#multipleEntryModal">Multiple Entry</button>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="variance" id="variance">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <span class="badge text-bg-primary">NEW ITEM</span>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="col-2 ">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <textarea class="form-control form-control-sm remarks" rows="1" style="max-height: 150px" disabled><?= $item->remarks; ?></textarea></td>
                                                            <?php else: ?>  
                                                                <textarea class="form-control form-control-sm remarks" rows="1" style="max-height: 150px"><?= $item->remarks; ?></textarea></td>
                                                            <?php endif ?>

                                                        <td class="docRef"><input type="file" class="form-control form-control-sm" multiple></td>
                                                        <td class="text-center validate"><input type="checkbox" class="form-check-input rowCheckbox"></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="submitLiquidation" data-id="<?= $id; ?>">Submit</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="forValidation" role="tabpanel" aria-labelledby="forValidationTab">
                        <div class="row m-2"> 
                            <div class="data-table">
                                <div class="table-reponsive">
                                    <table class="table table-hover display" id="dataTable3">
                                        <thead>
                                            <tr>
                                                <th class="col-3">Items</th>
                                                <th>Description</th>
                                                <th class="col-1 text-center">RFP No.</th>
                                                <th class="col-2">RFP Amount</th>
                                                <th class="col-2">Actual Amount</th>
                                                <th class="col-2">Variance</th>
                                                <th class="col-2">Remarks</th>
                                                <th class="col-2 text-center">Document Reference</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($liquidation_item as $item): ?>
                                                <?php if ($item->user_id == $this->session->userdata('user_id') && $item->status == '1'): ?>

                                                    <tr>
                                                        <td class="col-3" id="item"><?= $item->item; ?></td>
                                                        <td class="col" id="description">**description from another table in multiple entry </td>
                                                        <td class="col-1 text-center" id="rfpno"><?= $item->rfp_no; ?></td>
                                                        <td class="col-2 rfpAmount" id="rfpAmount"><?= number_format($item->rfp_amount, 2); ?></td>
                                                        <td class="col-2"><?= $item->actual_amount ?></td>
                                                        <td class="variance"><?= $item->variance ?></td>
                                                        <td class="col-2 "><?= $item->remarks ?></td>
                                                        <td class="docRef text-center">
                                                            <?= !empty($item->doc_ref) ? '<a href="' . $item->doc_ref . '" target="_blank"><span class="badge bg-primary">open file</span></a>' : '<span class="badge bg-danger">not provided</span>' ?>
                                                        </td>
                                                        <td class="text-center validate"><input type="checkbox" class="form-check-input rowCheckbox"></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                     
                                            <!-- see main.js #submitLiquidation click -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-danger me-2" id="removeBtn">Remove from Validation</button>
                            <button type="button" class="btn btn-sm btn-primary" id="forValidationBtn">Submit for Validation</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="validated" role="tabpanel" aria-labelledby="validatedTab">
                        <div class="row m-2"> 
                            <div class="data-table">
                                <div class="d-flex justify-content-end">
                                    
                                </div>
                                <div class="table-reponsive">
                                    <table class="table table-hover display" id="dataTable4">
                                    <thead>
                                        
                                                <tr>
                                                    <th class="col-3">Items</th>
                                                    <th>Description</th>
                                                    <th class="col-1 text-center">RFP No.</th>
                                                    <th class="col-2">RFP Amount</th>
                                                    <th class="col-2">Actual Amount</th>
                                                    <th class="col-2">Variance</th>
                                                    <th class="col-2">Remarks</th>
                                                    <th class="col-2 text-center">Document Reference</th>
                                                    <th>Status</th>
                                                </tr>
                                           
                                        </thead>
                                        <tbody>
                                            <?php foreach ($liquidation_item as $item): ?>
                                                <?php if ($item->user_id == $this->session->userdata('user_id') && ($item->status == '2' || $item->status == '3')): ?>
                                                    <tr>
                                                        <td class="col-3" id="item"><?= $item->item; ?></td>
                                                        <td class="col" id="description">**description from another table in multiple entry </td>
                                                        <td class="col-1 text-center" id="rfpno"><?= $item->rfp_no; ?></td>
                                                        <td class="col-2 rfpAmount" id="rfpAmount"><?= number_format($item->rfp_amount, 2); ?></td>
                                                        <td class="col-2"><?= $item->actual_amount ?></td>
                                                        <td class="variance"><?= $item->variance ?></td>
                                                        <td class="col-2 "><?= $item->remarks ?></td>
                                                        <td class="docRef text-center">
                                                            <?= !empty($item->doc_ref) ? '<a href="' . $item->doc_ref . '" target="_blank"><span class="badge bg-primary">open file</span></a>' : '<span class="badge bg-danger">not provided</span>' ?>
                                                        </td>
                                                        <td class="text-center validate small"><?= ($item->status == '2') ? 'Pending TAD' :  'Pending Accounting' ?></td>
                                                    </tr>
                                                <?php endif; ?>
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
  	</div>
    <button onclick="toggleChat()" class="chat-toggle-btn btn btn-primary rounded-circle">
        <i class="fas fa-comments"></i>
        <span class="position-absolute start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">New alerts</span>
        </span>
    </button>
    <div class="notes-window">
        <div class="notes-header text-white p-3 text-center">
            Notes
        </div>
        <div class="chat-messages p-3" id="notes-list">
            <?php if (!empty($notes)): ?>
                <?php foreach($notes as $note): ?>
                    <?php if($note->sender == $this->session->userdata('fullname')): ?>
                        <div class="sender">
                            <div class="d-flex justify-content-between text-secondary">
                                <div class="d-flex justify-content-end align-items-end">
                                    <p class="small">
                                        <?php
                                            date_default_timezone_set('Asia/Singapore'); 
                                            echo date('F j, Y H:i A', strtotime($note->timestamp));
                                        ?>
                                    </p>
                                </div>
                                <div>
                                    <p class="small text-end"><strong><?= $note->sender; ?></strong></p>
                                </div>
                            </div>
                            <div class=""> 
                                <div class="imessage d-flex justify-content-end align-items-right">
                                    <p class="from-me p-2">
                                    <?= $note->notes; ?>
                                    </p>
                                    <div class="profile-notes right">
                                        <img src="<?= base_url('assets/images/bg-ship.jpg'); ?>" class="rounded-circle">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="receiver">
                            <div class="d-flex justify-content-between text-secondary">
                                <div>
                                    <p class="small"><strong><?= $note->sender; ?></strong></p>
                                    <p class="small"><?= $note->sender; ?></p>
                                </div>
                                <div class="d-flex justify-content-end align-items-end">
                                    <p class="small">
                                        <?php
                                            date_default_timezone_set('Asia/Singapore'); 
                                            echo date('F j, Y H:i A', strtotime($note->timestamp));
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="imessage d-flex">
                                    <div class="profile-notes">
                                        <img src="<?= base_url('assets/images/bg-ship.jpg'); ?>" class="rounded-circle">
                                    </div>
                                    <p class="from-them p-2">
                                    <?= $note->notes; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No notes available.</p>
            <?php endif; ?>
        </div>
        <form action="<?php echo site_url('vesselitem/view/' . $id );?>" method="POST">
            <input type="hidden" name="liq_ref" value="<?php echo $id; ?>">
            <input type="hidden" name="sender" value="<?php echo $this->session->userdata('username'); ?>">
            <input type="hidden" name="timestamp" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <input type="text" class="form-control" name="notes" placeholder="Type a message...">
        </form>



    </div>

    <?php if($this->session->userdata('user_type') == 2): ?>
        <button onclick="toggleBreakdown()" class="breakdown-toggle-btn btn btn-warning rounded-circle">
            <i class="fa-solid fa-money-bill-transfer"></i>
            <!-- <span class="position-absolute start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                <span class="visually-hidden">New alerts</span>
            </span> -->
        </button>
        <div class="breakdown-window">
            <div class="breakdown-header text-white p-3 text-center">
                Credit Breakdown
            </div>
            <div class="breakdown-content p-3">                        
                <div class="d-flex justify-content-between align-items-end">
                    <h4><strong>Credit Breakdown:</strong></h4>
                    <p class="text-danger small"><strong>CURRENCY:</strong> PHP</p>
                </div>
                <table class="table table-warning table-hover">
                    <caption class="small">As of <span id="currentTime"></span></caption>
                    <thead>
                        <tr>
                            <th class="col-3">Vessel/Voyage</th>
                            <th class="col-3">Total</th>
                            <th class="text-end col-6">Credited Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="breakdown-row">
                            <td>Vessel Name V123</td>
                            <td>20,000.00</td>
                            <td class="text-end">20,000.00</td>
                        </tr>
                        <tr class="breakdown-row">
                            <td>Vessel Name V123</td>
                            <td>20,000.00</td>
                            <td class="text-end">20,000.00</td>
                        </tr>
                        <tr class="breakdown-row">
                            <td>Vessel Name V123</td>
                            <td>20,000.00</td>
                            <td class="text-end">20,000.00</td>
                        </tr>
                    </tbody>
                </table>
                <h4 class="text-end bold">PHP 60,0000.00</h4>
            </div>
        </div>
    <?php endif; ?>
  <!-- Modals -->
  <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="changePasswordModalLabel">Change Your Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" action="<?= site_url('login/change_password'); ?>" method="post">
                        <div class="mb-3">
                            <label for="currentUserPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="old_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="newUserPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmUserPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" required>
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
	<div class="modal fade" id="multipleEntryModal" tabindex="-1" aria-labelledby="multipleEntryModalLabel">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="multipleEntryModalLabel">Multiple Entry</h1>
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
						<div class="mt-3">
							<strong>Total: </strong><span id="totalAmount">0.00</span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary submit" data-bs-dismiss="modal" id="submitBtn">Submit</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="submissionConfirmationModal" tabindex="-1" aria-labelledby="submissionConfirmationModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="submissionConfirmationModalLabel">Confirmation</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					Are you sure you want to submit this item(s) liquidation for validation?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" id="confirmSubmit" data-bs-dismiss="modal">Confirm</button>
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
                            <label for="amount">Amount: </label>
                            <input type="text" class="form-control form-control-sm mb-2" placeholder="0.00" id="newAmount">
                        </div>
                    </div>
                    <div class="row m-2">
                        <label for="remarks">Remarks: </label>
                        <textarea class="form-control form-control-sm mb-2" rows="3" style="max-height: 150px;" id="newRemarks"></textarea>
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
	
    <script>
        function toggleChat() {
            const chat = document.querySelector('.notes-window');
            chat.classList.toggle('open');
        }
        function toggleBreakdown() {
            const chat = document.querySelector('.breakdown-window');
            chat.classList.toggle('open');
        }
        function showTime() {
            document.getElementById('currentTime').innerHTML = new Date().toUTCString();
        }
        showTime();
        setInterval(function () {
            showTime();
        }, 1000);
    </script>
    <script>
       $('#markComplete').on('click', function(event) {
            event.preventDefault(); 

            Swal.fire({
                title: 'Archive Confirmation',
                text: 'Are you sure you want to archive this item? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, archive it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    <?php $this->session->unset_userdata('error'); ?> 
                    Swal.fire({
                        title: "Liquidation Complete!",
                        icon: "success"
                    }).then(() => {
                        window.location.href = "<?= site_url('vesselitem/archive/' . $id); ?>";
                    })
                }
            });
        });
    </script>
		
</body>
</html>