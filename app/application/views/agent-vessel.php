<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WALLEM - L1QUID8</title>
    <link rel="icon" type="image/png" href="images/liquidate.ico">

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
        <?php require_once(APPPATH . 'views/layout/header.php'); ?>
        <div class="main-container bg-gradient">
            <div class="cont mb-3">
                <div class="row p-0">
                    <div class="col-2 d-flex justify-content-center align-items-center agent-section">
                        <div class="agent-name ps-3">
                            <h4><?= $vessel_data[0]->supplier; ?></h4>
                            <p class="label small">ATTENDING SUPERCARGO</p>
                        </div>
                    </div>
                    <div class="col-9 text-center my-3 vessel-section d-flex justify-content-between align-items-center">
                        <div class="col-3  gap-2 d-flex justify-content-center align-items-center">
                            <div class="">
                                <i class="fa-solid fa-ship fa-xl text-warning"></i>
                            </div>
                            <div class="col text-start mb-2">
                                <p class="label">VESSEL</p>
                                <p class="title bold"><?= $vessel_data[0]->vessel_name; ?></p>
                            </div>
                        </div>
                        <div class="gap-2 d-flex justify-content-center align-items-center">
                            <div class="">
                                <i class="fa-solid fa-anchor fa-xl text-info"></i>
                            </div>
                            <div class="col text-start mb-2">
                                <p class="label">VOYAGE</p>
                                <p class="title bold"><?= $vessel_data[0]->voyno; ?></p>
                            </div>
                        </div>
                        <div class="gap-2 d-flex justify-content-center align-items-center">
                            <div class="">
                                <i class="fa-solid fa-water fa-xl text-primary"></i>
                            </div>
                            <div class="col text-start">
                                <p class="label">PORT</p>
                                <p class="title bold"><?= $vessel_data[0]->port; ?></p>
                            </div>
                        </div>
                        <div class="d-block justify-content-start align-items-center">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-2">
                                    <i class="fa-solid fa-clock fa-xl text-primary"></i>
                                </div>
                                <div class="col text-start">
                                    <p class="label">ARRIVAL</p>
                                    <p class="title bold"><?= date('Y-m-d H:i', strtotime($vessel_data[0]->eta)); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-2">
                                    <i class="fa-solid fa-clock fa-xl text-success"></i>
                                </div>
                                <div class="col text-start">
                                    <p class="label">DEPARTURE</p>
                                    <p class="title bold"><?= date('Y-m-d H:i', strtotime($vessel_data[0]->etd)); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="cont">
                    <div class="row d-flex justify-content-center align-items-center dtTitle">
                        <h5 class="col mb-2">Vessel Items Liquidation</h5>
                    </div>
                    <nav>
                        <div class="nav nav-tabs liquidation-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="pendingTab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true"><i class="fa-regular fa-clock pe-2"></i>Item(s) for Validation</button>    
                            <button class="nav-link" id="validatedTab" data-bs-toggle="tab" data-bs-target="#validated" type="button" role="tab" aria-controls="validated" aria-selected="false"><i class="fa-solid fa-circle-check pe-2"></i>Validated Item(s)</button>            
                        </div>
                    </nav>
                    
                    <div class="tab-content" id="nav-tabContent">          
                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pendingTab">
                            <div class="row m-2"> 
                                <div class="data-table">
                                    <!-- items table for VOO/OM -->
                                    <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
                                        <table class="table table-striped table-hover display" id="dataTable6">
                                            <thead>
                                                <tr>
                                                    <th class="">Items</th>
                                                    <th class="">Description</th>
                                                    <th class="col-1 text-center">RFP No.</th>
                                                    <th class="">RFP Amount</th>
                                                    <th class="">Actual Amount</th>
                                                    <th class="">Variance</th>
                                                    <th class="col-1 text-center">Remarks</th>
                                                    <th class="col-1 text-center">Document</th>
                                                    <th class="col-1 text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($vessel_items as $item): ?>
                                                    <?php if ($item->status == 2): ?>
                                                        <tr>
                                                            <td>
                                                                <?= $item->item; ?>
                                                                <?php if($item->controlled == 0): ?>
                                                                    <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td></td>
                                                            <td class="col-1 text-center"><?= $item->rfp_no; ?></td>
                                                            <td id="debit"><span class="label text-dark"><?= $item->rfp_amount; ?></td>
                                                            <td id="credit"><span class="label text-dark"><?= $item->actual_amount; ?></td>
                                                            <td><?= $item->variance; ?></td>
                                                            <td class="col-1 text-center"><?= $item->remarks ?></td>
                                                            <td><a href="https://drive.google.com/drive/folders/1WGxD2F_E9Sv9CiCYYiR2p6xfu9On5Ewt?usp=drive_link">link this to the gdrive folder</a></td>
                                                            <td class="text-center">
                                                                <?= $item->status ?>
                                                                <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div> 
                                    <!-- items table for accounting -->
                                    <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                                        <table class="table table-striped table-hover display" id="dataTable9">
                                            <thead>
                                                <tr>
                                                    <th class="col-3">Items</th>
                                                    <th class="col">Description</th>
                                                    <th class="col-1 text-center">RFP No.</th>
                                                    <th class="col-2">RFP Amount</th>
                                                    <th class="col-2">Actual Amount</th>
                                                    <th class="col-2">Variance</th>
                                                    <th class="col-2">Remarks</th>
                                                    <th class="col-2 text-center">Document</th>
                                                    <th class="col text-center">Validate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($vessel_items)): ?>
                                                    <?php foreach ($vessel_items as $item): ?>
                                                        <?php if ($item->status == 2): ?>
                                                            <tr>
                                                                <td>
                                                                    <?= $item->item; ?>
                                                                    <?php if($item->controlled == 0): ?>
                                                                        <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td></td>
                                                                <td class="text-center"><?= $item->rfp_no; ?></td>
                                                                <td id="debit"><span class="label text-dark"><?= $item->rfp_amount; ?></td>
                                                                <td id="credit"><span class="label text-dark"><?= $item->actual_amount; ?></td>
                                                                <td><?= $item->variance; ?></td>
                                                                <td><?= $item->remarks ?></td>
                                                                <td><a href="https://drive.google.com/drive/folders/1WGxD2F_E9Sv9CiCYYiR2p6xfu9On5Ewt?usp=drive_link">link this to the gdrive folder</a></td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" class="form-check-input rowCheckbox">
                                                                    <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                                <?php if($this->session->userdata('user_type') == '3'): ?>
                                    <div class="row mt-3">
                                        <div class="col d-flex gap-2 justify-content-end align-items-end">
                                            <button class="btn btn-success" id="validateAllBtn">
                                                Check All
                                            </button>
                                            <button class="btn btn-primary" id="<?= ($this->session->userdata('user_type') == 3) ? 'confirmValidationA' : 'confirmValidationV'; ?>">
                                                Confirm
                                            </button>
                                        </div>
                                    </div>
                                <? endif ?>                
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
                                    <!-- table for voo/om validated -->
                                    <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
                                        <table class="table table-striped table-hover display" id="dataTable7">
                                            <thead>
                                                <tr>
                                                    <th class="col-3">Items</th>
                                                    <th class="col">Description</th>
                                                    <th class="col-1 text-center">RFP No.</th>
                                                    <th class="col-2">RFP Amount</th>
                                                    <th class="col-2">Actual Amount</th>
                                                    <th class="col-2">Variance</th>
                                                    <th class="col-2">Remarks</th>
                                                    <th class="col-2 text-center">Document</th>
                                                    <th class="col text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($vessel_items as $item): ?>
                                                    <?php if ($item->status == 3): ?>
                                                        <tr>
                                                            <td>
                                                                <?= $item->item; ?>
                                                                <?php if($item->controlled == 0): ?>
                                                                    <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td></td>
                                                            <td class="text-center"><?= $item->rfp_no; ?></td>
                                                            <td id="debit"><span class="label text-dark"><?= $item->rfp_amount; ?></td>
                                                            <td id="credit"><span class="label text-dark"><?= $item->actual_amount; ?></td>
                                                            <td><?= $item->variance; ?></td>
                                                            <td><?= $item->remarks ?></td>
                                                            <td><a href="https://drive.google.com/drive/folders/1WGxD2F_E9Sv9CiCYYiR2p6xfu9On5Ewt?usp=drive_link">link this to the gdrive folder</a></td>
                                                            <td class="text-center"><?= $item->status ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>    
                                    <!-- table for accounting validated-->
                                    <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                                        <table class="table table-striped table-hover display" id="dataTable10">
                                            <thead>
                                                <tr>
                                                    <th class="col-3">Items</th>
                                                    <th class="col">Description</th>
                                                    <th class="col-1 text-center">RFP No.</th>
                                                    <th class="col-2">RFP Amount</th>
                                                    <th class="col-2">Actual Amount</th>
                                                    <th class="col-2">Variance</th>
                                                    <th class="col-2">Remarks</th>
                                                    <th class="col-2 text-center">Document</th>
                                                    <th class="col text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($vessel_items as $item): ?>
                                                    <?php if ($item->status == 3): ?>
                                                        <tr>
                                                            <td>
                                                                <?= $item->item; ?>
                                                                <?php if($item->controlled == 0): ?>
                                                                    <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td></td>
                                                            <td class="text-center"><?= $item->rfp_no; ?></td>
                                                            <td id="debit"><span class="label text-dark"><?= $item->rfp_amount; ?></td>
                                                            <td id="credit"><span class="label text-dark"><?= $item->actual_amount; ?></td>
                                                            <td><?= $item->variance; ?></td>
                                                            <td><?= $item->remarks ?></td>
                                                            <td><a href="https://drive.google.com/drive/folders/1WGxD2F_E9Sv9CiCYYiR2p6xfu9On5Ewt?usp=drive_link">link this to the gdrive folder</a></td>
                                                            <td class="text-center"><?= $item->status ?></td>
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
    <!-- Modals -->
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
        $('#validateAllBtn').on('click', function() {
            $('.form-check-input').each(function() {
                $(this).prop('checked', !$(this).prop('checked'));
            });
        });
    </script>
</body>
</html>
