<?php require_once(APPPATH . 'views/layout/head.php'); ?>
<body>
    <div class="container-fluid">
    <?php require_once(APPPATH . 'views/layout/header.php'); ?>
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
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pendingTab">
                        <div class="row m-2"> 
                            <div class="data-table">
                                <div class="d-flex justify-content-end mb-2 gap-2">
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#itemSubmissionModal">
                                        <i class="fa-solid fa-plus"></i>
                                        Add Item
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        <i class="fa-solid fa-upload"></i>    
                                        upload liquidation documents
                                    </button>
                                </div>
                                
                                <div class="table-reponsive">
                                    <table class="table table-hover display" id="dataTable2">
                                        <thead>
                                            <tr>
                                                <th class="">Items</th>
                                                
                                                <th class="col-1 text-center">RFP No.</th>
                                                <th>Currency</th>
                                                <th class="">RFP Amount</th>
                                                <th class="">Actual Amount</th>
                                                <th class="">Variance</th>
                                                <th class="col-1 text-center">Remarks</th>
                                                <th class="col-1 text-center">Document</th>
                                                <th class="col-1 text-center">Validate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($liquidation_item as $item): ?>
                                                
                                                <?php if ($item->user_id == $this->session->userdata('user_id') && $item->status == '1'): ?>
                                                    
                                                    <tr id="item-<?= $item->id ?>">
                                                        <td class="item " id="item">
                                                            <?= $item->item; ?>
                                                            <?php if($item->controlled == 0): ?>
                                                                <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        
                                                        <td class="text-center col-1 rfpno" id="rfpno">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <span class="badge text-bg-primary">NEW ITEM</span>
                                                            <?php else: ?>  
                                                                <?= $item->rfp_no; ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="currency"><?= $item->currency ?></td>
                                                        <td class="rfpAmount" id="rfpAmount">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <span class="badge text-bg-primary">NEW ITEM</span>
                                                            <?php else: ?>  
                                                                <?= number_format($item->rfp_amount, 2); ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="text-end">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>" disabled>
                                                            <?php else: ?> 
                                                                <?php if($item->hasBreakdown == '1'): ?>
                                                                    <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>" disabled>
                                                                    <button class="btn btn-sm text-primary multiple-btn" data-bs-toggle="modal" data-bs-target="#multipleEntryModal" data-item="<?= $item->id ?>">Cost Breakdown</button>
                                                                <?php else: ?>
                                                                    <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>" required>
                                                                    <button class="btn btn-sm text-primary multiple-btn" data-bs-toggle="modal" data-bs-target="#multipleEntryModal" data-item="<?= $item->id ?>">Cost Breakdown</button>
                                                                <?php endif ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="variance" id="variance">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <span class="badge text-bg-primary">NEW ITEM</span>
                                                            <?php else: ?>

                                                            <?php endif ?>
                                                        </td>
                                                        <td class="col-1 text-center">
                                                            <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                <i class="fa-solid fa-message"></i>
                                                            </button>
                                                        </td>
                                                        <td class="col-1 docRef text-center">
                                                            <button class="btn btn-sm" type="button" id="uploadButton">
                                                                <i class="fa-solid fa-upload"></i>
                                                            </button>
                                                        </td>
                                                        <td class="col-1 text-center validate">
                                                            <input type="checkbox" class="form-check-input rowCheckbox">
                                                            <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
                                                        </td>
                                                    </tr>
                                                    <!-- <tr class="child-row" style="display: none;">
                                                        <td style="min-width: 100%;">
                                                            <?php if (!empty($breakdown_cost)): ?>
                                                               
                                                                <?php foreach ($breakdown_cost as $cost): ?>
                                                                    <?php if ($cost['item_id'] == $item->id): ?>
                                                                        
                                                                        
                                                                        <tr class="table-info">
                                                                            <td class="bold">
                                                                                <?= isset($cost['id']) ? $cost['id'] : 'N/A'; ?>. &nbsp; 
                                                                                <?= isset($cost['description']) ? $cost['description'] : 'N/A'; ?>
                                                                            </td>
                                                                            <td class="text-center"><?= isset($cost['rfp_no']) ? $cost['rfp_no'] : 'N/A'; ?></td>
                                                                            <td><?= isset($cost['currency']) ? $cost['currency'] : 'N/A'; ?></td>
                                                                            <td><?= isset($cost['rfp_amount']) ? $cost['rfp_amount'] : 'N/A'; ?></td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= isset($cost['amount']) ? $cost['amount'] : 'N/A'; ?>" disabled>
                                                                            </td>
                                                                            <td><?= isset($cost['variance']) ? $cost['variance'] : 'N/A'; ?></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    <?php endif; ?> 
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <p>No breakdown cost available.</p>
                                                            <?php endif; ?>

                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr> -->
                                                    
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="submitLiquidation" >Submit</button>
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
                                                <th class="col-1 text-center">RFP No.</th>
                                                <th><?= $item->currency ?></th>
                                                <th class="col-2">RFP Amount</th>
                                                <th class="col-2">Actual Amount</th>
                                                <th class="col-2">Variance</th>
                                                <th class="col-2">Remarks</th>
                                                <th class="col-2 text-center">Document</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($liquidation_item as $item): ?>
                                                <?php if ($item->user_id == $this->session->userdata('user_id') && $item->status == '2'): ?>
                                                    <tr>
                                                        <td class="col-3" id="item">
                                                            <?= $item->item; ?>
                                                            <?php if($item->controlled == 0): ?>
                                                                <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="col-1 text-center" id="rfpno"><?= $item->rfp_no; ?></td>
                                                        <td><?= $item->currency ?></td>
                                                        <td class="col-2 rfpAmount" id="rfpAmount"><?= number_format($item->rfp_amount, 2); ?></td>
                                                        <td class="col-2"><?= number_format($item->actual_amount, 2) ?></td>
                                                        <td class="variance"><?= number_format($item->variance, 2) ?></td>
                                                        <td class="col-2 ">
                                                            <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                <i class="fa-solid fa-message"></i>
                                                            </button>
                                                        </td>
                                                        <td class="docRef text-center">
                                                            <?= !empty($item->doc_ref) ? '<a href="' . $item->doc_ref . '" target="_blank"><span class="badge bg-primary">open file</span></a>' : '<span class="badge bg-danger">not provided</span>' ?>
                                                        </td>
                                                        <td class="text-center validate small"><?= ($item->status == '1') ? 'Pending VOO/OM' : (($item->status == '2') ? 'Pending Accounting' : 'Status Unknown') ?>
                                                        </td>
                                                        
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <!-- see main.js #submitLiquidation click -->
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