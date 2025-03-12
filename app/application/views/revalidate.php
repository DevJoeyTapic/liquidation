<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('layout/head'); ?>
<body>
    <?php $this->load->view('layout/header'); ?>
    
    <div class="main-container bg-gradient">
        <div class="search-result cont d-flex flex-column" style="display: <?= ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
            <div class="data-table">
                <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
                    <table class="table  table-hover display" id="dataForRevalidation">
                        <thead>
                            <tr>
                                <th class="col-2">Agent</th>
                                <th class="col-2">Items</th>
                                <th class="col-1 text-center">RFP No.</th>
                                <th class="text-center">Currency</th>
                                <th class="col-2">RFP Amount</th>
                                <th class="col-2">Actual Amount</th>
                                <th class="col-2">Variance</th>
                                <th class="col-1">Variance %</th>
                                <th class="col-2 text-center">Remarks</th>
                                <th class="col text-center">Validate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($for_am)): ?>
                                <?php foreach($for_am as $item): ?>
                                    <tr>
                                        <td><?= $item->supplier ?></td>
                                        <td>
                                            <?= $item->item; ?>
                                            <?php if($item->isNew == '1'): ?>  
                                                <span class="badge rounded-pill text-bg-primary">NEW ITEM</span>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $item->rfp_no; ?></td>
                                        <td><?= $item->currency; ?></td>
                                        <td><?= number_format($item->rfp_amount, 2); ?></td>
                                        <td><?= number_format($item->actual_amount, 2); ?></td>
                                        <td><?= number_format($item->variance, 2); ?></td>
                                        <td><?=number_format($item->variance_percent, 2) . '%'; ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $item->id ?>">
                                                <i class="fa-solid fa-message"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input rowCheckbox">
                                            <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($this->session->userdata('user_type') == '4'): ?>
                <div class="row mt-3">
                    <div class="col d-flex gap-2 justify-content-end align-items-end">
                        <button class="btn btn-danger" id="revalidateBtn">
                            Re-validate
                        </button>
                        <button class="btn btn-success" id="checkAllBtn">
                            Check All
                        </button>
                        <button class="btn btn-primary" id="payToAgentBtn">
                            Pay To Agent
                        </button>
                    </div>
                </div>
            <? endif ?>           
        </div>
    </div>
    <?php $this->load->view('partials/modals'); ?>

    <script>
        $(document).ready(function() {
            var dataTableForRevalidation = $("#dataForRevalidation").DataTable({ 
                paging: true,
                searching: true,
                pageLength: 10,
            });
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
    </script>
    <script>
        $(document).ready(function() {
            let baseUrl = 'http://192.168.197.61:3000';

            $('#payToAgentBtn').on('click', function() {
                Swal.fire({
                    title: 'Pay to Agent',
                    text: 'Are you sure you want to mark the item(s) as validated?',
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
                            const checkedRows = $("#dataForRevalidation .rowCheckbox:checked").closest("tr");

                            let dataToSubmit = [];
                            
                            if (checkedRows.length > 0) {
                                checkedRows.each(function () {
                                    const item_id = $(this).find("input[name='item_id']").val();
                                    
                                    dataToSubmit.push({
                                        item_id: item_id
                                    });
                                });

                                $.ajax({
                                    url: baseUrl + '/revalidate/pay_to_agent/', 
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
    <script>
        $(document).ready(function() {
            let baseUrl = 'http://192.168.197.61:3000';

            $('#revalidateBtn').on('click', function() {
                Swal.fire({
                    title: 'Return To AP/AR',
                    text: 'Are you sure you want to return the item(s) to AP/AR for revalidation?',
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
                            const checkedRows = $("#dataForRevalidation .rowCheckbox:checked").closest("tr");

                            let dataToSubmit = [];
                            
                            if (checkedRows.length > 0) {
                                checkedRows.each(function () {
                                    const item_id = $(this).find("input[name='item_id']").val();
                                    
                                    dataToSubmit.push({
                                        item_id: item_id
                                    });
                                });

                                $.ajax({
                                    url: baseUrl + '/revalidate/return_to_apar/', 
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
