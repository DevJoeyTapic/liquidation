<?php require_once(APPPATH . 'views/layout/head.php'); ?>
<body>
    <div class="container-fluid">
        <?php require_once(APPPATH . 'views/layout/header.php'); ?>

        <div class="main-container bg-gradient">
            <?php if($this->session->userdata('user_type') != 3): ?>
                <div class="search-result cont d-flex flex-column" style="display: <?= ($this->session->userdata('user_type') != 5) ? 'block' : 'none'; ?>">
                    <div class="data-table">
                        <!-- table view for voo/om -->
                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 4) ? 'block' : 'none'; ?>">
                            <table class="table table-hover " id="dataTable5">
                                <thead>
                                    <tr>
                                        <th>Agent</th>
                                        <th>Vessel</th>
                                        <th>Voyage</th>
                                        <th>Port</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($voo_om_liquidations)): ?>
                                        <?php foreach ($voo_om_liquidations as $liquidation): ?>
                                            
                                            <tr onclick="window.location.href='<?= site_url('agentvessel/view/' . $liquidation->id); ?>'"> 
                                                <td><?= $liquidation->supplier; ?></td>
                                                <td><?= $liquidation->vessel_name; ?></td>
                                                <td><?= $liquidation->voyno; ?></td>
                                                <td><?= $liquidation->port; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif ?>
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
                                        <?php if ($liquidation->user_id == $this->session->userdata('user_id') && $liquidation->status !== '2'): ?>
                                            <tr onclick="window.location.href='<?= site_url('vesselitem/view/' . $liquidation->id); ?>'"> 
                                                <td><?= $liquidation->vessel_name; ?></td>
                                                <td><?= $liquidation->voyno; ?></td>
                                                <td><?= $liquidation->port; ?></td>
                                                <td><?= $liquidation->eta; ?></td>
                                                <td><?= $liquidation->etd; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            <?php endif; ?>

            <div class="col-11 mx-auto" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                <?php
                    $countLiquidation = 0; // Initialize the counter
                    if (!empty($accounting_liquidations)): ?>
                        <?php foreach ($accounting_liquidations as $liquidation): ?>
                            <?php if($liquidation->item_status == 2 || $liquidation->item_status == 3): ?>
                                <?php $countLiquidation++; // Increment counter for matching status ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php 
                    $countUnliquidated = 0;
                    if (!empty($accounting_liquidations)): ?>
                        <?php foreach ($accounting_liquidations as $liquidation): ?>
                            <?php if($liquidation->item_status == 1 || $liquidation->item_status == 2 || $liquidation->item_status == 3): ?>
                                <?php $countUnliquidated++; // Increment counter for matching status ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <div class="mt-3">
                    <div class="accordion" id="forValidation">
                        <div class="accordion-item">
                            <h4 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    <div class="btn">
                                        <p class="bold">For Validation</p>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <?= $countLiquidation; ?>
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </div>
                                </button>
                            </h4>
                            <div id="collapseTwo" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="data-table">
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                                            <table class="table table-hover " id="dataTable8">
                                                <thead>
                                                    <tr>
                                                        <th>Vessel</th>
                                                        <th>Voyage</th>
                                                        <th>Port</th>
                                                        <th>Agent</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($accounting_liquidations)): ?>
                                                        <?php foreach ($accounting_liquidations as $liquidation): ?>
                                                            <?php if($liquidation->item_status == 2 || $liquidation->item_status == 3): ?>
                                                                <tr onclick="window.location.href='<?= site_url('agentvessel/view/' . $liquidation->id); ?>'"> 
                                                                    <td><?= $liquidation->vessel_name; ?></td>
                                                                    <td><?= $liquidation->voyno; ?></td>
                                                                    <td><?= $liquidation->port; ?></td>
                                                                    <td><?= $liquidation->supplier; ?></td>
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
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="accordion" id="unliquidated">
                        <div class="accordion-item">
                            <h4 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="btn">
                                        <p class="bold">Pending Liquidation (Unliquidated)</p>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <?= $countUnliquidated; ?>
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </div>
                                </button>
                            </h4>
                            <div id="collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="data-table">
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                                            <table class="table table-hover " id="unliquidatedTable">
                                                <thead>
                                                    <tr>
                                                        <th>Vessel</th>
                                                        <th>Voyage</th>
                                                        <th>Port</th>
                                                        <th>Agent</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($accounting_liquidations)): ?>
                                                        <?php foreach ($accounting_liquidations as $liquidation): ?>
                                                            <?php if($liquidation->item_status == '1' || $liquidation->item_status == '2' || $liquidation->item_status == '3'): ?>
                                                                <tr onclick="window.location.href='<?= site_url('agentvessel/view/' . $liquidation->id); ?>'"> 
                                                                    <td><?= $liquidation->vessel_name; ?></td>
                                                                    <td><?= $liquidation->voyno; ?></td>
                                                                    <td><?= $liquidation->port; ?></td>
                                                                    <td><?= $liquidation->supplier; ?></td>
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
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
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

    <script>
        function toggleBreakdown() {
            const chat = document.querySelector('.breakdown-window');
            chat.classList.toggle('open');
        }
        $(document).ready(function() {
            $('#unliquidatedTable').DataTable({
                paging: true,
                searching: true,
                pageLength: 10,
            });
        });
    </script>
</body>
</html>
