<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('layout/head'); ?>
<body>
    <?php $this->load->view('partials/loading-screen'); ?>
    <div class="container-fluid">
    <?php $this->load->view('layout/header'); ?>
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

            <?php $this->load->view('partials/liquidation-overview'); ?>

            <div class="cont">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-3">Item Liquidation</h5>
                    <div class="justify-content-end text-end mb-2">
                        <button class="btn btn-primary btn-sm small" id="refreshData">
                            <i class="fa-solid fa-arrows-rotate pe-2"></i>Refresh Data
                        </button>
                        <div>
                            <p class="small text-secondary text-end">Last updated on <?php echo date('Y-m-d H:i:s', strtotime('+8 hours')); ?></p>
                        </div>
                    </div>
                </div>
                <nav>
                    <div class="nav nav-tabs liquidation-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="pendingTab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true"><i class="fa-regular fa-clock pe-2"></i>Pending Item(s) Liquidation</button>    
                        <button class="nav-link" id="completedTab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false"><i class="fa-solid fa-circle-check pe-2"></i>Completed Item(s)</button>
                        <button class="nav-link" id="forAmendmentTab" data-bs-toggle="tab" data-bs-target="#forAmendment" type="button" role="tab" aria-controls="forAmendment" aria-selected="false"><i class="fa-solid fa-user-pen pe-2"></i></i>For Amendment Item(s)</button>
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
                                    <button type="button" class="btn btn-primary btn-sm" id="uploadMainBtn" data-bs-toggle="modal" data-bs-target="#uploadModal" data-id="<?= $id; ?>">
                                        <i class="fa-solid fa-upload"></i>    
                                        upload liquidation documents
                                    </button>
                                </div>
                                
                                <div class="table-reponsive">
                                    <table class="table table-hover display " id="pendingTableAg">
                                        <thead>
                                            <tr>
                                                <th>Items</th>
                                                <th class="text-center">RFP No.</th>
                                                <th>Currency</th>
                                                <th>Requested Amount</th>
                                                <th>Amount Received</th>
                                                <th>Actual Expenses</th>
                                                <th>Variance</th>
                                                <th>Variance %</th>
                                                <th class="text-center">Remarks</th>
                                                <th class="text-center">Validate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($liquidation_item as $item): ?>
                                                <?php if ($item->user_id == $this->session->userdata('user_id') && $item->status == '0'): ?>
                                                    
                                                    <tr id="item-<?= $item->id ?>">
                                                        <td class="item" id="item">
                                                            <?= $item->item; ?>
                                                            <?php if($item->controlled == 0): ?>
                                                                <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                            <?php endif; ?>
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="rfpno" id="rfpno">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                
                                                            <?php else: ?>  
                                                                <?= $item->rfp_no; ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="currency"><?= $item->currency ?></td>
                                                        <td class="rfpAmount" id="rfpAmount">
                                                            <?php if($item->isNew == '1' && $item->controlled == '1'): ?>
                                                                <?php echo('0.00'); ?>
                                                            <?php elseif($item->controlled == '0' && $item->isNew == '1'): ?>
                                                                <?php echo('0.00'); ?>
                                                            <?php else: ?>
                                                                <?= number_format($item->rfp_amount, 2); ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="amountReceived">
                                                            <?php if($item->isNew == '1' && $item->controlled == '1'): ?>
                                                                <?php echo('0.00'); ?>
                                                            <?php elseif($item->controlled == '0' && $item->isNew == '1' || $item->controlled == '0'): ?>
                                                                <?php echo('0.00'); ?>
                                                            <?php else: ?>
                                                                <?= number_format($item->rfp_amount, 2); ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-end">
                                                            
                                                            <?php
                                                            // Count the number of liquidation items where controlled == 1 and status == 4
                                                            $matching_items = 0;
                                                            $total_matching_items = 0;

                                                            foreach ($liquidation_item as $liquidation) {
                                                                if ($liquidation->controlled == 1) {
                                                                    $total_matching_items++;
                                                                    if ($liquidation->status == 4) {
                                                                        $matching_items++;
                                                                    }
                                                                }
                                                            }


                                                                // Check if all controlled == 1 items have status 4
                                                                $allControlledStatus4 = ($matching_items === $total_matching_items);
                                                                ?>

                                                                <?php if ($item->isNew == '1'): ?>  
                                                                    <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>">
                                                                <?php else: ?> 
                                                                    <?php if ($item->hasBreakdown == '1' ): ?>
                                                                        <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>" disabled>
                                                                    <?php else: ?>
                                                                        <?php if($allControlledStatus4): ?>
                                                                            <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>" required>
                                                                        <?php else: ?>
                                                                            <?php if($item->controlled == 0): ?>
                                                                                <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>" disabled>
                                                                            <?php else: ?>
                                                                                <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>" required>
                                                                        
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                        </td>
                                                        <td class="variance" id="variance">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <?= number_format($item->variance, 2); ?>
                                                            <?php elseif($item->status == '8'|| $item->status == '7'): ?>
                                                                <?= number_format($item->variance, 2); ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="variance_percent">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <?= number_format($item->variance_percent, 2) . '%'; ?>
                                                            <?php elseif($item->status == '8'|| $item->status == '7'): ?>
                                                                <?= number_format($item->variance_percent, 2) . '%'; ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="text-center">
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
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="submitLiquidation" >Submit</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completedTab">
                        <div class="row m-2"> 
                            <div class="data-table">
                                <div class="table-reponsive">
                                    <table class="table table-hover display" id="completeTableAg">
                                        <thead>
                                            <tr>
                                                <th>Items</th>
                                                <th>RFP No.</th>
                                                <th>Currency</th>
                                                <th>Requested Amount</th>
                                                <th>Amount Received</th>
                                                <th>Actual Expenses</th>
                                                <th>Variance</th>
                                                <th>Variance %</th>
                                                <th class="text-center">Remarks</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($liquidation_item as $item): ?>
                                                <?php if ($item->user_id == $this->session->userdata('user_id') && $item->status == '4'): ?>
                                                    <tr>
                                                        <td id="item">
                                                            <?= $item->item; ?>
                                                            <?php if($item->controlled == 0): ?>
                                                                <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                            <?php endif; ?>
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                                            <?php endif ?>
                                                        </td>
                                                        <td id="rfpno"><?= $item->rfp_no; ?></td>
                                                        <td><?= $item->currency ?></td>
                                                        <td class="rfpAmount" id="rfpAmount">
                                                            <?php if($item->isNew == '1' && $item->controlled == '1'): ?>
                                                                <?php echo('0.00'); ?>
                                                            <?php elseif($item->controlled == '0' && $item->isNew == '1'): ?>
                                                                <?php echo('0.00'); ?>
                                                            <?php else: ?>
                                                                <?= number_format($item->rfp_amount, 2); ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="amountReceived">
                                                            <?php if($item->isNew == '1' && $item->controlled == '1'): ?>
                                                                <?php echo('0.00'); ?>
                                                            <?php elseif($item->controlled == '0' && $item->isNew == '1' || $item->controlled == '0'): ?>
                                                                <?php echo('0.00'); ?>
                                                            <?php else: ?>
                                                                <?= number_format($item->rfp_amount, 2); ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= number_format($item->actual_amount, 2) ?></td>
                                                        <td class="variance">
                                                            <?= number_format($item->variance, 2); ?>
                                                        </td>
                                                        <td class="variance">
                                                            <?= number_format($item->variance_percent, 2) . '%'; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                <i class="fa-solid fa-message"></i>
                                                            </button>
                                                        </td>
                                                        <td class="text-center validate">
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
                                            <!-- see main.js #submitLiquidation click -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="forAmendment" role="tabpanel" aria-labelledby="forAmendmentTab">
                        <div class="row m-2"> 
                            <div class="data-table">
                                <div class="table-reponsive">
                                    <table class="table table-hover display" id="forAmendmentTableAg">
                                        <thead>
                                            <tr>
                                                <th>Items</th>
                                                <th>RFP No.</th>
                                                <th><?= $item->currency ?></th>
                                                <th>Requested Amount</th>
                                                <th>Amount Received</th>
                                                <th>Actual Expenses</th>
                                                <th>Variance</th>
                                                <th>Variance %</th>
                                                <th class="text-center">Remarks</th>
                                                <th class="text-center">Validate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($liquidation_item as $item): ?>
                                                <?php if ($item->user_id == $this->session->userdata('user_id') && $item->status == '7' || $item->status == '8'): ?>
                                                    
                                                    <tr id="item-<?= $item->id ?>">
                                                        <td class="item " id="item">
                                                            <?= $item->item; ?>
                                                            <?php if($item->controlled == 0): ?>
                                                                <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                            <?php endif; ?>
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="rfpno" id="rfpno">
                                                            <?= $item->rfp_no ?>
                                                        </td>
                                                        <td class="currency"><?= $item->currency ?></td>
                                                        <td class="rfpAmount" id="rfpAmount">
                                                            <?php if($item->isNew == '1' && $item->controlled == '1'): ?>
                                                                <?php echo('0.00'); ?>
                                                            <?php elseif($item->controlled == '0' && $item->isNew == '1'): ?>
                                                                <?php echo('0.00'); ?>
                                                            <?php else: ?>
                                                                <?= number_format($item->rfp_amount, 2); ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="amountReceived">
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <?= number_format($item->actual_amount, 2); ?>
                                                            <?php elseif($item->controlled == '0'): ?>  
                                                                <?php echo ('0.00'); ?>
                                                            <?php else: ?>  
                                                                <?= number_format($item->rfp_amount, 2); ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td>
                                                            <?php if($item->isNew == '1'): ?>  
                                                                <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>">
                                                            <?php else: ?> 
                                                                <?php if($item->hasBreakdown == '1'): ?>
                                                                    <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>" disabled>
                                                                    <!-- <button class="btn btn-sm text-primary multiple-btn" data-bs-toggle="modal" data-bs-target="#multipleEntryModal" data-item="<?= $item->id ?>">Cost Breakdown</button> -->
                                                                <?php else: ?>
                                                                    <input type="text" class="form-control form-control-sm actualAmount" id="actualAmount" name="actualAmount" value="<?= $item->actual_amount; ?>" required>
                                                                    <!-- <button class="btn btn-sm text-primary multiple-btn" data-bs-toggle="modal" data-bs-target="#multipleEntryModal" data-item="<?= $item->id ?>">Cost Breakdown</button> -->
                                                                <?php endif ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="variance" id="<?= ($this->session->userdata('user_type') == 5 ? 'variance' : '') ?>">
                                                            <?= number_format($item->variance, 2) ?>
                                                        </td>
                                                        <td class="variance_percent">
                                                            <?= number_format($item->variance_percent, 2) . '%' ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                                <i class="fa-solid fa-message"></i>
                                                            </button>
                                                        </td>
                                                        </td>
                                                        <td class="text-center validate">
                                                            <input type="checkbox" class="form-check-input rowCheckbox">
                                                            <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
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
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="submitAmended" >Submit</button>
                        </div>
                    </div>
                </div>
            </div>
		</div>
  	</div>
    <?php $this->load->view('partials/notes-window'); ?>
    <?php $this->load->view('partials/breakdown-window'); ?>
    <?php require_once(APPPATH . 'views/partials/modals.php')?>


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
                        window.location.href = "<?= base_url('vesselitem/archive/' . $id); ?>";
                    })
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#pendingTableAg').DataTable({
                paging: true,
                searching: true,
                pageLength: 10,
                order: []
            });
            $('#liquidatedTableAg').DataTable({
                paging: true,
                searching: true,
                pageLength: 10,
                order: []
            });
            $('#completeTableAg').DataTable({
                paging: true,
                searching: true,
                pageLength: 10,
                order: []
            });
            $('#forAmendmentTableAg').DataTable({
                paging: true,
                searching: true,
                pageLength: 10,
                order: []
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let baseUrl = 'https://agents.wallem.com.ph';
            $('#submitLiquidation').on('click', function() {
                Swal.fire({
                    title: 'Submit Liquidation Item/s',
                    text: 'Are you sure you want to submit item/s for liquidation?',
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
                            const checkedRows = $("#pendingTableAg .rowCheckbox:checked").closest("tr");

                            let dataToSubmit = [];

                            if (checkedRows.length > 0) {
                                checkedRows.each(function () {
                                    const actualAmount = $(this).find("td:nth-child(6) input").val();
                                    const variance = $(this).find(".variance").text();
                                    const item_id = $(this).find("input[name='item_id']").val();

                                    dataToSubmit.push({
                                        actualAmount: actualAmount,
                                        variance: variance,
                                        item_id: item_id
                                    });
                                });
                                console.log(dataToSubmit);

                                $.ajax({
                                    url: baseUrl + '/vesselitem/submit_for_validation', // Ensure baseUrl is defined
                                    method: 'POST',
                                    data: {
                                        items: dataToSubmit // Sending all items in a single request
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
            $('#submitAmended').on('click', function() {
                Swal.fire({
                    title: 'Submit Item/s for Amendment',
                    text: 'Are you sure you want to submit item/s for amendment?',
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
                            const checkedRows = $("#forAmendmentTableAg .rowCheckbox:checked").closest("tr");

                            let dataToSubmit = [];

                            if (checkedRows.length > 0) {
                                checkedRows.each(function () {
                                    const actualAmount = $(this).find("td:nth-child(6) input").val();
                                    const variance = $(this).find(".variance").text();
                                    const item_id = $(this).find("input[name='item_id']").val();

                                    dataToSubmit.push({
                                        actualAmount: actualAmount,
                                        variance: variance,
                                        item_id: item_id
                                    });
                                });

                                $.ajax({
                                    url: baseUrl + '/vesselitem/submit_for_amendment', // Ensure baseUrl is defined
                                    method: 'POST',
                                    data: {
                                        items: dataToSubmit // Sending all items in a single request
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
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#refreshData').click(function() {
                location.reload();
                $('.page-loader').removeClass('d-none');
                setTimeout(function() {
                    $('.page-loader').addClass('d-none');
                }, 10000);
            });
        });
    </script>		
</body>
</html>