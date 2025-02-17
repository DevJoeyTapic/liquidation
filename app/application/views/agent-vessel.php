<?php require_once(APPPATH . 'views/layout/head.php'); ?>
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
            <div class="row">
                <div class="col-9">
                    <div class="cont">
                        <div class="row d-flex justify-content-center align-items-center dtTitle">
                            <h5 class="col mb-2">Vessel Items Liquidation</h5>
                        </div>
                        <nav>
                            <div class="nav nav-tabs liquidation-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="pendingTab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false"><i class="fa-solid fa-user-clock pe-2"></i>Pending Item(s) for Liquidation</button>    
                                <button class="nav-link" id="forValidationTab" data-bs-toggle="tab" data-bs-target="#forValidation" type="button" role="tab" aria-controls="forValidation" aria-selected="true"><i class="fa-regular fa-clock pe-2"></i>Item(s) for Validation</button>    
                                <button class="nav-link" id="validatedTab" data-bs-toggle="tab" data-bs-target="#validated" type="button" role="tab" aria-controls="validated" aria-selected="false"><i class="fa-solid fa-circle-check pe-2"></i>Validated Item(s)</button>            
                            </div>
                        </nav>
                        
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pendingTab">
                                <div class="row m-2"> 
                                    <div class="data-table">
                                        <!-- table for unliquidated items (TAD) -->
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableLiquidationT">
                                                <thead>
                                                    <tr>
                                                        <th class="">Items</th>
                                                        <th class="">Description</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="">RFP Amount</th>
                                                        <th class="">Actual Amount</th>
                                                        <th class="">Variance</th>
                                                        <th class="col-1 text-center">Remarks</th>
                                                        <th class="col-1 text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($vessel_items as $item): ?>
                                                        <?php if ($item->status == 1): ?>
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
                                                                <td class="col-1 text-center">
                                                                <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                            <i class="fa-solid fa-message"></i>
                                                        </button>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="badge text-bg-secondary">
                                                                        <?= ($item->status == 1) ? 'Pending Agent' : '' ?>
                                                                    </span>
                                                                    <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div> 
                                        <!-- table for unliquidated items (accounting) -->
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableLiquidationA">
                                                <thead>
                                                    <tr>
                                                        <th class="col-3">Items</th>
                                                        <th class="col">Description</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="col-2">RFP Amount</th>
                                                        <th class="col-2">Actual Amount</th>
                                                        <th class="col-2">Variance</th>
                                                        <th class="col-2">Remarks</th>
                                                        <th class="col text-center">Validate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(!empty($vessel_items)): ?>
                                                        <?php foreach ($vessel_items as $item): ?>
                                                            <?php if ($item->status == 1): ?>
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
                                                                    <td>
                                                                        <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                            <i class="fa-solid fa-message"></i>
                                                                        </button>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="badge text-bg-secondary">
                                                                            <?= ($item->status == 1) ? 'Pending Agent' : '' ?>
                                                                        </span>
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
                                </div>
                            </div>   
                            <div class="tab-pane fade" id="forValidation" role="tabpanel" aria-labelledby="forValidationTab">
                                <div class="row m-2"> 
                                    <div class="data-table">
                                        <!-- table for validation for VOO/OM -->
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableForValidationT">
                                                <thead>
                                                    <tr>
                                                        <th class="">Items</th>
                                                        <th class="">Description</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="">RFP Amount</th>
                                                        <th class="">Actual Amount</th>
                                                        <th class="">Variance</th>
                                                        <th class="col-1 text-center">Remarks</th>
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
                                                                <td class="col-1 text-center">
                                                                    <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                        <i class="fa-solid fa-message"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox" class="form-check-input rowCheckbox">
                                                                    <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div> 
                                        <!-- table for validation for accounting -->
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableForValidationA">
                                                <thead>
                                                    <tr>
                                                        <th class="col-3">Items</th>
                                                        <th class="col">Description</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="col-2">RFP Amount</th>
                                                        <th class="col-2">Actual Amount</th>
                                                        <th class="col-2">Variance</th>
                                                        <th class="col-2">Remarks</th>
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
                                                                    <td>
                                                                        <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                            <i class="fa-solid fa-message"></i>
                                                                        </button>
                                                                    </td>
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
                                        <!-- table for validated items (TAD) -->
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableValidatedT">
                                                <thead>
                                                    <tr>
                                                        <th class="col-3">Items</th>
                                                        <th class="col">Description</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="col-2">RFP Amount</th>
                                                        <th class="col-2">Actual Amount</th>
                                                        <th class="col-2">Variance</th>
                                                        <th class="col-2">Remarks</th>
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
                                                                <td>
                                                                    <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                        <i class="fa-solid fa-message"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="badge text-bg-secondary">
                                                                        <?= ($item->status == 3) ? 'Validated' : '' ?>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>    
                                        <!-- table for validated items (accounting) -->
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableValidatedA">
                                                <thead>
                                                    <tr>
                                                        <th class="col-3">Items</th>
                                                        <th class="col">Description</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="col-2">RFP Amount</th>
                                                        <th class="col-2">Actual Amount</th>
                                                        <th class="col-2">Variance</th>
                                                        <th class="col-2">Remarks</th>
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
                                                                <td>
                                                                    <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                        <i class="fa-solid fa-message"></i>
                                                                    </button>
                                                                </td>
                                                                    <td class="text-center">
                                                                    <span class="badge text-bg-secondary">
                                                                        <?= ($item->status == 3) ? 'Validated' : '' ?>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
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
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-3 ps-0">
                    <div class="cont pt-0" style="max-height: 100%; overflow-y: scroll;">
                        <div class="row">
                            <div class="col position-sticky pt-4" style="top: 0; background: white; z-index: 100;">
                                <h5>Liquidation Attachments</h5>
                                <hr>
                            </div>
                            <ul id="fileNamesList" class="list-group mt-2 p-0">
                                <li class="list-group-item mx-3">
                                    <i class="fa-solid fa-file-pdf"></i>
                                    <span><?= $item->item ?></span>
                                    <span>Liquidation.pdf</span>
                                </li>
                            </ul>
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
    <?php require_once(APPPATH . 'views/partials/modals.php'); ?>

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
    <script>
        $(document).ready(function() {
            var dataTableLiquidationT = $("#dataTableLiquidationT").DataTable({
                paging: true,
                searching: true,
                pageLength: 10,
            });
            var dataTableLiquidationA = $("#dataTableLiquidationA").DataTable({
                paging: true,
                searching: true,
                pageLength: 10,
            });
            var dataTableForValidationT = $("#dataTableForValidationT").DataTable({
                paging: true,
                searching: true,
                pageLength: 10,
            });
            var dataTableForValidationA = $("#dataTableForValidationA").DataTable({
                paging: true,
                searching: true,
                pageLength: 10,
            });
            var dataTableValidatedT = $("#dataTableValidatedT").DataTable({
                paging: true,
                searching: true,
                pageLength: 10,
            });
            var dataTableValidatedA = $("#dataTableValidatedA").DataTable({ 
                paging: true,
                searching: true,
                pageLength: 10,
            });

        });
    </script>
</body>
</html>
