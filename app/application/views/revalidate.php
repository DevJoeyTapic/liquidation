<?php require_once(APPPATH . 'views/layout/head.php'); ?>

<body>
    <?php require_once(APPPATH . 'views/layout/header.php'); ?>
    
    <div class="main-container bg-gradient">
        <div class="search-result cont d-flex flex-column" style="display: <?= ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
            <div class="data-table">
                <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
                    <table class="table  table-hover display" id="dataForRevalidation">
                        <thead>
                            <tr>
                                <th class="col-2">Agent</th>
                                <th class="col-3">Items</th>
                                <th class="col-1">Description</th>
                                <th class="col-1 text-center">RFP No.</th>
                                <th class="col-2">RFP Amount</th>
                                <th class="col-2">Actual Amount</th>
                                <th class="col-2">Variance</th>
                                <th class="col-2">Remarks</th>
                                <th class="col text-center">Validate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($revalidated_liquidations)): ?>
                                
                                <?php foreach ($revalidated_liquidations as $revalidated): ?>
                                    <?php if ($revalidated->status == '4'): ?>
                                        <tr>
                                            <td><?= $revalidated->supplier; ?></td>
                                            <td>
                                                <?= $revalidated->item; ?>
                                                <?php if($revalidated->controlled == 0): ?>
                                                    <span class="badge rounded-pill text-bg-warning">Controlled</span>
                                                <?php endif; ?>
                                            </td>
                                            <td></td>
                                            <td class="text-center"><?= $revalidated->rfp_no; ?></td>
                                            <td id="debit"><span class="label text-dark"><?= $revalidated->rfp_amount; ?></td>
                                            <td id="credit"><span class="label text-dark"><?= $revalidated->actual_amount; ?></td>
                                            <td><?= $revalidated->variance; ?></td>
                                            <td>
                                                <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#showItemRemarksModal" id="showItemRemarks" data-item="<?= $revalidated->id ?>">
                                                    <i class="fa-solid fa-message"></i>
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check-input rowCheckbox">
                                                <input type="hidden" name="item_id" value="<?php echo $revalidated->id; ?>">
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($this->session->userdata('user_type') == '4'): ?>
                <div class="row mt-3">
                    <div class="col d-flex gap-2 justify-content-end align-items-end">
                        <button class="btn btn-success" id="revalidateAllBtn">
                            Check All
                        </button>
                        <button class="btn btn-primary" id="revalidateBtn">
                            Re-validate
                        </button>
                    </div>
                </div>
            <? endif ?>           
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var dataTableForRevalidation = $("#dataForRevalidation").DataTable({ 
                paging: true,
                searching: true,
                pageLength: 10,
            });
        });
    </script>
</body>
