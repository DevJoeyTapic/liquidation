<?php require_once(APPPATH . 'views/layout/head.php'); ?>
<body>
    <div class="container-fluid">
        <?php require_once(APPPATH . 'views/layout/header.php'); ?>

        <div class="main-container bg-gradient">
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
                    <!-- table view for accounting -->
                    <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3) ? 'block' : 'none'; ?>">
                        <table class="table table-hover " id="dataTable8">
                            <thead>
                                <tr>
                                    <th>Agent</th>
                                    <th>Vessel</th>
                                    <th>Voyage</th>
                                    <th>Port</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($accounting_liquidations)): ?>
                                    <?php foreach ($accounting_liquidations as $liquidation): ?>
                                        
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
            <div style="display: <?= ($this->session->userdata('user_type') == 5) ? 'block' : 'none'; ?>">
                <div class="accordion" id="user-accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <strong>For Liquidation</strong>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#user-accordion">
                            <div class="accordion-body">
                                
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
    <script>
        function toggleBreakdown() {
            const chat = document.querySelector('.breakdown-window');
            chat.classList.toggle('open');
        }
        // function showTime() {
        //     document.getElementById('currentTime').innerHTML = new Date().toUTCString();
        // }
        // showTime();
        // setInterval(function () {
        //     showTime();
        // }, 1000);

        
    </script>
</body>
</html>
