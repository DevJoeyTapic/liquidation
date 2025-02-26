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
            <?php require_once(APPPATH . 'views/partials/liquidation-overview.php'); ?>

            <div class="row">
                <div class="col-9">
                    <div class="cont">
                        <div class="row d-flex justify-content-center align-items-center dtTitle">
                            <h5 class="col mb-2">Vessel Items Liquidation</h5>
                        </div>
                        <nav>
                            <div class="nav nav-tabs liquidation-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="pendingTab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false"><i class="fa-solid fa-user-clock pe-2"></i>Pending Item(s) for Liquidation</button>    
                                <button class="nav-link" id="forValidationTab" data-bs-toggle="tab" data-bs-target="#forValidation" type="button" role="tab" aria-controls="forValidation" aria-selected="true"><i class="fa-regular fa-clock pe-2"></i><?= ($this->session->userdata('user_type') == '5') ? 'Pending OTP' : 'Item(s) for Validation' ?></button>    
                                <button class="nav-link" id="validatedTab" style="display: <?= ($this->session->userdata('user_type') == '5') ? 'none' : 'block' ?>"data-bs-toggle="tab" data-bs-target="#validated" type="button" role="tab" aria-controls="validated" aria-selected="false"><i class="fa-solid fa-circle-check pe-2"></i>Validated Item(s)</button>            
                                <button class="nav-link" id="forRevalidationTab" style="display: <?= ($this->session->userdata('user_type') == '5') ? 'none' : 'block' ?>"data-bs-toggle="tab" data-bs-target="#forRevalidation" type="button" role="tab" aria-controls="forRevalidation" aria-selected="false"><i class="fa-solid fa-user-xmark pe-2"></i>For Revalidation</button>            

                            </div>
                        </nav>
                        
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pendingTab">
                                <div class="row m-2"> 
                                    <div class="data-table">
                                        <!-- table for unliquidated items (TAD) -->
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 5) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableLiquidationT">
                                                <thead>
                                                    <tr>
                                                        <th class="">Items</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="text-center">Currency</th>
                                                        <th class="">RFP Amount</th>
                                                        <th class="">Actual Amount</th>
                                                        <th class="">Variance</th>
                                                        <th class="col-1 text-center">Remarks</th>
                                                        <th class="col-1 text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($vessel_items as $item): ?>
                                                        <?php if ($item->status == 0): ?>
                                                            <tr>
                                                                <td>
                                                                    <?= $item->item; ?>
                                                                    <?php if($item->controlled == 0): ?>
                                                                        <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                                    <?php endif; ?>
                                                                    <?php if($item->isNew == '1'): ?>  
                                                                        <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td class="col-1 text-center"><?= $item->rfp_no; ?></td>
                                                                <td class="text-center"><?= $item->currency ?></td>
                                                                <td id="debit"><?= $item->rfp_amount; ?></td>
                                                                <td id="credit"><?= $item->actual_amount; ?></td>
                                                                <td><?= $item->variance; ?></td>
                                                                <td class="col-1 text-center">
                                                                    <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                        <i class="fa-solid fa-message"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="text-center">
                                                                <span class="badge 
                                                                    <?= ($item->status == 0) ? 'text-bg-secondary' : '' ?>
                                                                    <?= ($item->status == 1) ? 'text-bg-primary' : '' ?>
                                                                    <?= ($item->status == 2) ? 'text-bg-info' : '' ?>
                                                                    <?= ($item->status == 3) ? 'text-bg-success' : '' ?>
                                                                    <?= ($item->status == 4) ? 'text-bg-danger' : '' ?>
                                                                    <?= ($item->status == 5) ? 'text-bg-warning' : '' ?>
                                                                ">
                                                                    <?= ($item->status == 0) ? 'Pending Agent' : '' ?>
                                                                    <?= ($item->status == 1) ? 'Pending Voo/OM' : '' ?>
                                                                    <?= ($item->status == 2) ? 'Pending Accounting' : '' ?>
                                                                    <?= ($item->status == 3) ? 'Validated' : '' ?>
                                                                    <?= ($item->status == 4) ? 'For Re-validation' : '' ?>
                                                                    <?= ($item->status == 5) ? 'Revalidated' : '' ?>
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
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) || ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableLiquidationA">
                                                <thead>
                                                    <tr>
                                                        <th class="col-3">Items</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="text-center">Currency</th>
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
                                                            <?php if ($item->status == 0): ?>
                                                                <tr>
                                                                    <td>
                                                                        <?= $item->item; ?>
                                                                        <?php if($item->controlled == 0): ?>
                                                                            <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                                        <?php endif; ?>
                                                                        <?php if($item->isNew == '1'): ?>  
                                                                            <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                                                        <?php endif ?>
                                                                    </td>
                                                                    <td class="text-center"><?= $item->rfp_no; ?></td>
                                                                    <td class="text-center"><?= $item->currency ?></td>
                                                                    <td id="debit"><?= $item->rfp_amount; ?></td>
                                                                    <td id="credit"><?= $item->actual_amount; ?></td>
                                                                    <td><?= $item->variance; ?></td>
                                                                    <td>
                                                                        <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                            <i class="fa-solid fa-message"></i>
                                                                        </button>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="badge 
                                                                            <?= ($item->status == 0) ? 'text-bg-secondary' : '' ?>
                                                                            <?= ($item->status == 1) ? 'text-bg-primary' : '' ?>
                                                                            <?= ($item->status == 2) ? 'text-bg-success' : '' ?>
                                                                        ">
                                                                            <?= ($item->status == 0) ? 'Pending Agent' : '' ?>
                                                                            <?= ($item->status == 1) ? 'Pending Voo/OM' : '' ?>
                                                                            <?= ($item->status == 2) ? 'Pending Accounting' : '' ?>
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
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 5) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableForValidationT">
                                                <thead>
                                                    <tr>
                                                        <th class="">Items</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="text-center">Currency</th>
                                                        <th class="">RFP Amount</th>
                                                        <th class="">Actual Amount</th>
                                                        <th class="">Variance</th>
                                                        <th class="col-1 text-center">Remarks</th>
                                                        <th class="col-1 text-center">Validate</th>
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
                                                                    <?php if($item->isNew == '1'): ?>  
                                                                        <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td class="col-1 text-center">
                                                                    <?= $item->rfp_no ?>
                                                                </td>
                                                                <td class="text-center"><?= $item->currency ?></td>
                                                                <td id="debit">
                                                                    <?php if($item->isNew == '1'): ?>
                                                                        <?= number_format($item->actual_amount, 2); ?>
                                                                    <?php else: ?>
                                                                        <?= number_format($item->rfp_amount, 2); ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td id="credit">
                                                                    <?= number_format($item->actual_amount, 2); ?>
                                                                </td>
                                                                <td>
                                                                    <?= number_format($item->variance, 2); ?>
                                                                </td>
                                                                <td class="col-1 rtext-center">
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
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="text-center">Currency</th>
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
                                                                        <?php if($item->isNew == '1'): ?>  
                                                                            <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                                                        <?php endif ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php if($item->isNew == '1'): ?>  
                                                                            
                                                                        <?php else: ?>
                                                                            <?= $item->rfp_no ?>
                                                                        <?php endif ?>
                                                                    </td>
                                                                    <td class="text-center"><?= $item->currency ?></td>
                                                                    <td id="debit">
                                                                        <?php if($item->isNew == '1'): ?>  
                                                                            <?= number_format($item->actual_amount, 2) ?>
                                                                        <?php else: ?>
                                                                            <?= number_format($item->rfp_amount, 2) ?>
                                                                        <?php endif ?>
                                                                    </td>
                                                                    <td id="credit"><?= $item->actual_amount; ?></td>
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
                                                <button class="btn btn-danger" id="rtaBtn">
                                                    Amend
                                                </button>
                                                <button class="btn btn-success" id="checkAllBtn">
                                                    Check All
                                                </button>
                                                <button class="btn btn-primary" id="submitToAMBtn">
                                                    Submit to AM
                                                </button>
                                            </div>
                                        </div>
                                    <? endif ?>         
                                    <?php if($this->session->userdata('user_type') == '5'): ?>
                                        <div class="row mt-3">
                                            <div class="col d-flex gap-2 justify-content-end align-items-end">
                                                <button class="btn btn-danger" id="amendBtn">
                                                    Amend
                                                </button>
                                                <button class="btn btn-success" id="checkAllBtn">
                                                    Check All
                                                </button>
                                                <button class="btn btn-primary" id="otpBtn">
                                                    OK To Pay
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
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 5) ? 'block' : 'none'; ?>">
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
                                                        <?php if ($item->status == 2 ||$item->status == 3 || $item->status == 5): ?>
                                                            <tr>
                                                                <td>
                                                                    <?= $item->item; ?>
                                                                    <?php if($item->controlled == 0): ?>
                                                                        <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                                    <?php endif; ?>
                                                                    <?php if($item->isNew == '1'): ?>  
                                                                        <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td></td>
                                                                <td class="text-center"><?= $item->rfp_no; ?></td>
                                                                <td id="debit"><?= $item->rfp_amount; ?></td>
                                                                <td id="credit"><?= $item->actual_amount; ?></td>
                                                                <td><?= $item->variance; ?></td>
                                                                <td>
                                                                    <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                        <i class="fa-solid fa-message"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="badge 
                                                                        <?= ($item->status == 0) ? 'text-bg-secondary' : '' ?>
                                                                        <?= ($item->status == 1) ? 'text-bg-primary' : '' ?>
                                                                        <?= ($item->status == 2) ? 'text-bg-success' : '' ?>
                                                                        <?= ($item->status == 3) ? 'text-bg-success' : '' ?>
                                                                        <?= ($item->status == 4) ? 'text-bg-danger' : '' ?>
                                                                        <?= ($item->status == 5) ? 'text-bg-warning' : '' ?>
                                                                    ">
                                                                        <?= ($item->status == 0) ? 'Pending Agent' : '' ?>
                                                                        <?= ($item->status == 1) ? 'Pending Voo/OM' : '' ?>
                                                                        <?= ($item->status == 2) ? 'Pending Accounting' : '' ?>
                                                                        <?= ($item->status == 3) ? 'Validated' : '' ?>
                                                                        <?= ($item->status == 4) ? 'For Re-validation' : '' ?>
                                                                        <?= ($item->status == 5) ? 'Revalidated' : '' ?>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>    
                                        <!-- table for validated items (accounting) -->
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) || ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableValidatedA">
                                                <thead>
                                                    <tr>
                                                        <th class="col-3">Items</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="text-center">Currency</th>
                                                        <th class="col-2">RFP Amount</th>
                                                        <th class="col-2">Actual Amount</th>
                                                        <th class="col-2">Variance</th>
                                                        <th class="col-2">Remarks</th>
                                                        <th class="col text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($vessel_items as $item): ?>
                                                        <?php if ($item->status == 3 || $item->status == 1): ?>
                                                            <tr>
                                                                <td>
                                                                    <?= $item->item; ?>
                                                                    <?php if($item->controlled == 0): ?>
                                                                        <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                                    <?php endif; ?>
                                                                    <?php if($item->isNew == '1'): ?>  
                                                                        <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if($item->isNew == '1'): ?>  
                                                                    
                                                                    <?php else: ?>
                                                                        <?= $item->rfp_no ?>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td class="text-center"><?= $item->currency ?></td>
                                                                <td id="debit">
                                                                    <?php if($item->isNew == '1'): ?>  
                                                                        <?= number_format($item->actual_amount, 2) ?>
                                                                    <?php else: ?>
                                                                        <?= number_format($item->rfp_amount, 2) ?>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td id="credit"><?= $item->actual_amount; ?></td>
                                                                <td><?= $item->variance; ?></td>
                                                                <td>
                                                                    <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                        <i class="fa-solid fa-message"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php
                                                                        // Define the status-to-badge mapping
                                                                        $status_to_class = [
                                                                            '0' => 'bg-secondary', // Unliquidated
                                                                            '1' => 'bg-dark', // Liquidated
                                                                            '2' => 'bg-primary', // OK To Pay
                                                                            '3' => 'bg-info', // Validated
                                                                            '4' => 'bg-success', // Pay To Agent
                                                                            '5' => 'bg-danger', // Return To AP
                                                                            '6' => 'bg-warning', // Return To AP
                                                                            '7' => 'bg-light text-dark', // Return To Agent by AP
                                                                            '8' => 'bg-danger', // Amend
                                                                        ];

                                                                        // Determine the badge class based on the item's status
                                                                        $badge_class = isset($status_to_class[$item->status]) ? $status_to_class[$item->status] : '';
                                                                    ?>
                                                                    <span class="badge <?= $badge_class; ?>">
                                                                        <?= htmlspecialchars($item->desc_status); ?>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="forRevalidation" role="tabpanel" aria-labelledby="forRevalidationTab">
                                <div class="d-flex justify-content-end">
                                    <button class="btn text-primary">
                                        <i class="fa-solid fa-print pe-2"></i>Print Summary of Vessel Liquidation
                                    </button>
                                </div>
                                <div class="row m-2">
                                    <div class="data-table">   
                                        <!-- table for validated items (accounting) -->
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                                            <table class="table  table-hover display" id="dataTableForRevalidationA">
                                                <thead>
                                                    <tr>
                                                        <th class="col-3">Items</th>
                                                        <th class="col-1 text-center">RFP No.</th>
                                                        <th class="text-center">Currency</th>
                                                        <th class="col-2">RFP Amount</th>
                                                        <th class="col-2">Actual Amount</th>
                                                        <th class="col-2">Variance</th>
                                                        <th class="col-2">Remarks</th>
                                                        <th class="col text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($vessel_items as $item): ?>
                                                        <?php if ($item->status == 5): ?>
                                                            <tr>
                                                                <td>
                                                                    <?= $item->item; ?>
                                                                    <?php if($item->controlled == 0): ?>
                                                                        <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                                    <?php endif; ?>
                                                                    <?php if($item->isNew == '1'): ?>  
                                                                        <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if($item->isNew == '1'): ?> 

                                                                    <?php else: ?>
                                                                        <?= $item->rfp_no ?>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td class="text-center"><?= $item->currency ?></td>
                                                                <td id="debit">
                                                                    <?php if($item->isNew == '1'): ?> 
                                                                         <?= number_format($item->actual_amount, 2) ?>
                                                                    <?php else: ?>
                                                                        <?= number_format($item->rfp_amount, 2) ?>
                                                                    <?php endif ?>
                                                                </td>
                                                                <td id="credit"><?= $item->actual_amount; ?></td>
                                                                <td><?= $item->variance; ?></td>
                                                                <td>
                                                                    <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                        <i class="fa-solid fa-message"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="text-center validate">
                                                                    <input type="checkbox" class="form-check-input rowCheckbox">
                                                                    <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>  
                                    </div>
                                    <?php if($this->session->userdata('user_type') == '3'): ?>
                                        <div class="row mt-3">
                                            <div class="col d-flex gap-2 justify-content-end align-items-end">
                                                <button class="btn btn-danger" id="rtaBtns5">
                                                    Amend
                                                </button>
                                                <button class="btn btn-success" id="checkAllBtns5">
                                                    Check All
                                                </button>
                                                <button class="btn btn-primary" id="submitToAMBtns5">
                                                    Submit to AM
                                                </button>
                                            </div>
                                        </div>
                                    <? endif ?>         
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
    <?php require_once(APPPATH . 'views/partials/notes-window.php'); ?>
    <?php require_once(APPPATH . 'views/partials/breakdown-window.php'); ?>
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
            var dataTableForRevalidationA = $('#dataTableForRevalidationA').DataTable({
                paging: true,
                seraching: true,
                pageLength: 10
            })

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#checkAllBtn').on('click', function() {
                $('.form-check-input').each(function() {
                    $(this).prop('checked', !$(this).prop('checked'));
                });
                $('.form-check-input').trigger('change');
            });
            $('.rowCheckbox').on('change', function() {
                const checkedRows = $("#dataTableForValidationT .rowCheckbox:checked").closest("tr");
            });
        })
        $(document).ready(function() {
            $('#checkAllBtns5').on('click', function() {
                $('.form-check-input').each(function() {
                    $(this).prop('checked', !$(this).prop('checked'));
                });
                $('.form-check-input').trigger('change');
            });
        })
    </script>
    <!-- okay to pay by tad -->
    <script>
        $(document).ready(function() {
            let baseUrl = 'http://192.168.192.251:3000';

            $('#otpBtn').on('click', function() {
                Swal.fire({
                    title: 'Mark item/s as ok-to-pay',
                    text: 'Are you sure you want to mark item(s) as ok-to-pay?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Item/s Submitted!",
                            icon: "success"
                        }).then(() => {
                            const checkedRows = $("#dataTableForValidationT .rowCheckbox:checked").closest("tr");

                            let dataToSubmit = [];
                            
                            if (checkedRows.length > 0) {
                                checkedRows.each(function () {
                                    const item_id = $(this).find("input[name='item_id']").val();
                                    
                                    dataToSubmit.push({
                                        item_id: item_id
                                    });
                                });

                                $.ajax({
                                    url: baseUrl + '/agentvessel/ok_to_pay/', 
                                    method: 'POST',
                                    data: {
                                        items: dataToSubmit 
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        location.reload();
                                    },
                                    error: function(error) {
                                        Swal.fire({
                                            title: 'Submission Error',
                                            text: 'An error occurred while submitting the items. Please try again later.',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            }

                        });
                    }
                });
            });
        })
    </script>
    <!-- amend button for tad -->
    <script>
        $(document).ready(function() {
            let baseUrl = 'http://192.168.192.251:3000';

            $('#amendBtn').on('click', function() {
                Swal.fire({
                    title: 'Amend Item/s',
                    text: 'Are you sure you want to return this to agent for amendment?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Item/s Submitted!",
                            icon: "success"
                        }).then(() => {
                            const checkedRows = $("#dataTableForValidationT .rowCheckbox:checked").closest("tr");

                            let dataToSubmit = [];
                            
                            if (checkedRows.length > 0) {
                                checkedRows.each(function () {
                                    const item_id = $(this).find("input[name='item_id']").val();
                                    
                                    dataToSubmit.push({
                                        item_id: item_id
                                    });
                                });

                                $.ajax({
                                    url: baseUrl + '/agentvessel/for_amendment_tad', 
                                    method: 'POST',
                                    data: {
                                        items: dataToSubmit 
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        location.reload();
                                    },
                                    error: function(error) {
                                        Swal.fire({
                                            title: 'Submission Error',
                                            text: 'An error occurred while submitting the items. Please try again later.',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            }

                        });
                    }
                });
            });
        })
    </script>
    <!-- return to agent -->
    <script>
        $(document).ready(function() {
            let baseUrl = 'http://192.168.192.251:3000';

            $('#rtaBtn').on('click', function() {
                Swal.fire({
                    title: 'Return To Agent',
                    text: 'Are you sure you want to return this to agent for amendment?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Item/s Submitted!",
                            icon: "success"
                        }).then(() => {
                            const checkedRows = $("#dataTableForValidationA .rowCheckbox:checked").closest("tr");

                            let dataToSubmit = [];
                            
                            if (checkedRows.length > 0) {
                                checkedRows.each(function () {
                                    const item_id = $(this).find("input[name='item_id']").val();
                                    
                                    dataToSubmit.push({
                                        item_id: item_id
                                    });
                                });

                                $.ajax({
                                    url: baseUrl + '/agentvessel/for_amendment_acctg', 
                                    method: 'POST',
                                    data: {
                                        items: dataToSubmit 
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        location.reload();
                                    },
                                    error: function(error) {
                                        Swal.fire({
                                            title: 'Submission Error',
                                            text: 'An error occurred while submitting the items. Please try again later.',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            }

                        });
                    }
                });
            });
        })
    </script>
    <!-- submit to AM -->
    <script>
        $(document).ready(function() {
            let baseUrl = 'http://192.168.192.251:3000';

            $('#submitToAMBtn').on('click', function() {
                Swal.fire({
                    title: 'Submit for Validation',
                    text: 'Are you sure you want to submit this for validation?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Item/s Submitted!",
                            icon: "success"
                        }).then(() => {
                            const checkedRows = $("#dataTableForValidationA .rowCheckbox:checked").closest("tr");

                            let dataToSubmit = [];
                            
                            if (checkedRows.length > 0) {
                                checkedRows.each(function () {
                                    const item_id = $(this).find("input[name='item_id']").val();
                                    
                                    dataToSubmit.push({
                                        item_id: item_id
                                    });
                                });

                                $.ajax({
                                    url: baseUrl + '/agentvessel/submit_to_am', 
                                    method: 'POST',
                                    data: {
                                        items: dataToSubmit 
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        location.reload();
                                    },
                                    error: function(error) {
                                        Swal.fire({
                                            title: 'Submission Error',
                                            text: 'An error occurred while submitting the items. Please try again later.',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            }

                        });
                    }
                });
            });
        })
    </script>
    <!-- return to agent s5 -->
    <script>
        $(document).ready(function() {
            let baseUrl = 'http://192.168.192.251:3000';

            $('#rtaBtns5').on('click', function() {
                Swal.fire({
                    title: 'Return To Agent',
                    text: 'Are you sure you want to return this to agent for amendment?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Item/s Submitted!",
                            icon: "success"
                        }).then(() => {
                            const checkedRows = $("#dataTableForRevalidationA .rowCheckbox:checked").closest("tr");

                            let dataToSubmit = [];
                            
                            if (checkedRows.length > 0) {
                                checkedRows.each(function () {
                                    const item_id = $(this).find("input[name='item_id']").val();
                                    
                                    dataToSubmit.push({
                                        item_id: item_id
                                    });
                                });

                                $.ajax({
                                    url: baseUrl + '/agentvessel/for_amendment_acctg', 
                                    method: 'POST',
                                    data: {
                                        items: dataToSubmit 
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        location.reload();
                                    },
                                    error: function(error) {
                                        Swal.fire({
                                            title: 'Submission Error',
                                            text: 'An error occurred while submitting the items. Please try again later.',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            }

                        });
                    }
                });
            });
        })
    </script>
    <!-- submit to AM s5 -->
    <script>
        $(document).ready(function() {
            let baseUrl = 'http://192.168.192.251:3000';

            $('#submitToAMBtns5').on('click', function() {
                Swal.fire({
                    title: 'Submit for Validation',
                    text: 'Are you sure you want to submit this for validation?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Item/s Submitted!",
                            icon: "success"
                        }).then(() => {
                            const checkedRows = $("#dataTableForRevalidationA .rowCheckbox:checked").closest("tr");

                            let dataToSubmit = [];
                            
                            if (checkedRows.length > 0) {
                                checkedRows.each(function () {
                                    const item_id = $(this).find("input[name='item_id']").val();
                                    
                                    dataToSubmit.push({
                                        item_id: item_id
                                    });
                                });

                                $.ajax({
                                    url: baseUrl + '/agentvessel/submit_to_am', 
                                    method: 'POST',
                                    data: {
                                        items: dataToSubmit 
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        location.reload();
                                    },
                                    error: function(error) {
                                        Swal.fire({
                                            title: 'Submission Error',
                                            text: 'An error occurred while submitting the items. Please try again later.',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            }

                        });
                    }
                });
            });
        })
    </script>

</body>
</html>
