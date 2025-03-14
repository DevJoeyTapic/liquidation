<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('layout/head'); ?>
<body>
<?php $this->load->view('partials/loading-screen'); ?>
    <div class="container-fluid">
        <?php $this->load->view('layout/header'); ?>
        <div class="main-container bg-gradient">
            <div class="col-11 mx-auto" style="display: <?= ($this->session->userdata('user_type') == 2 || $this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5) ? 'block' : 'none'; ?>">
            <div class="justify-content-end text-end">
                <h3 class="welcome-user">Welcome aboard, <?= ucfirst($this->session->userdata('fullname')) . '!'; ?></h3>

                <button class="btn btn-primary btn-sm small" id="refreshData">
                    <i class="fa-solid fa-arrows-rotate pe-2" ></i>Refresh Data
                </button>
                <div>
                    <p class="small text-secondary text-end">Last updated on <?php echo date('Y-m-d H:i:s', strtotime('+8 hours')); ?></p>
                </div>
            </div>

                <?php
                    function countLiquidations($liquidations, $statusArray) {
                        $count = 0;
                        if (!empty($liquidations)) {
                            foreach ($liquidations as $liquidation) {
                                if (in_array($liquidation->item_status, $statusArray)) {
                                    $count++;
                                }
                            }
                        }
                        return $count;
                    }

                    // For User Type 2 (Agent)
                    if ($this->session->userdata('user_type') == 2):
                        // Counters for Agent Liquidations
                        $countUnliquidatedAg = countLiquidations($unliquidated_vessels, [0]); // Unliquidated
                        $countLiquidationAg = countLiquidations($pending_validation, [1, 2, 3, 5, 6, 7]); // For Validation
                        $countCompletedAg = countLiquidations($completed, [4]); // Completed
                        $countRevalidatedAg = countLiquidations($for_amendment, [7, 8]); // For Revalidation
                    endif; 

                    if($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5):
                        $countUnliquidated = countLiquidations($unliquidated_vessels, [0]);
                        $countCompleted = countLiquidations($completed, [4]);
                    endif;

                    // For User Type 3 (Accounting)
                    if ($this->session->userdata('user_type') == 3):
                        // Counters for Accounting Liquidations
                        $countLiquidationA = countLiquidations($pending_validation, [2]); // For Validation
                        $countForAMValidationA = countLiquidations($pending_validation, [3]); // For AM Validation
                        $countRevalidatedA = countLiquidations($for_amendment, [5, 7, 8]); // For Revalidation
                    endif;
                    if ($this->session->userdata('user_type') == 4):
                        // Counters for AM Validation
                        
                    endif;

                    // For User Type 5 (TAD)
                    if ($this->session->userdata('user_type') == 5):
                        // Counters for TAD Liquidations
                        $countLiquidationT = countLiquidations($pending_otp, [1]); // For Validation
                        $countForAPARAMValidationT = countLiquidations($pending_otp, [2,3,4]); // For AP/AR/AM Validation
                    endif;
                ?>
                <!-- Pending Liquidation (Unliquidated) -->
                <div class="mt-3">
                    <div class="accordion accordion-flush" id="unliquidated">
                        <div class="accordion-item">
                            <h4 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="btn text-start">
                                        <p class="bold">Pending Liquidation (Unliquidated)</p>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <?php if($this->session->userdata('user_type') == 2): ?>
                                                <?= $countUnliquidatedAg; ?>
                                            <?php elseif($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5): ?>
                                                <?= $countUnliquidated; ?>
                                            <?php endif; ?>
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </div>
                                </button>
                            </h4>
                            <div id="collapseOne" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                
                                    <div class="data-table">
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 2 || $this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5) ? 'block' : 'none'; ?>">
                                            <table class="table table-hover " id="unliquidatedTable">
                                                <thead>
                                                    <tr>
                                                        <th>Vessel</th>
                                                        <th>Voyage</th>
                                                        <th>Port</th>
                                                        <?php if($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5): ?>
                                                            <th>Agent</th>
                                                        <?php endif; ?>
                                                            <th>Arrival</th>
                                                            <th>Departure</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if($this->session->userdata('user_type') == 2): ?>
                                                        <?php if (!empty($unliquidated_vessels)): ?>
                                                            <?php foreach ($unliquidated_vessels as $liquidation): ?>
                                                                <?php if($liquidation->item_status == '0'): ?>
                                                                <tr onclick="window.location.href='<?= base_url('vesselitem/view/' . $liquidation->id); ?>'"> 
                                                                    <td><?= $liquidation->vessel_name; ?></td>
                                                                    <td><?= $liquidation->voyno; ?></td>
                                                                    <td><?= $liquidation->port; ?></td>
                                                                    <td><?= $liquidation->eta; ?></td>
                                                                    <td><?= $liquidation->etd; ?></td>
                                                                    <td>
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
                                                                            $badge_class = isset($status_to_class[$liquidation->item_status]) ? $status_to_class[$liquidation->item_status] : '';
                                                                        ?>
                                                                        <span class="badge <?= $badge_class; ?>">
                                                                            <?= htmlspecialchars($liquidation->desc_status); ?>
                                                                        </span>

                                                                    </td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php endif ?>
                                                        <?php elseif($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5): ?>
                                                            <?php if (!empty($unliquidated_vessels)): ?>
                                                                <?php foreach ($unliquidated_vessels as $liquidation): ?>
                                                                    <?php if($liquidation->item_status == '0'): ?>
                                                                    <tr onclick="window.location.href='<?= base_url('agentvessel/view/' . $liquidation->id); ?>'"> 
                                                                        <td><?= $liquidation->vessel_name; ?></td>
                                                                        <td><?= $liquidation->voyno; ?></td>
                                                                        <td><?= $liquidation->port; ?></td>
                                                                        <td><?= $liquidation->supplier; ?></td>
                                                                        <td><?= $liquidation->eta; ?></td>
                                                                        <td><?= $liquidation->etd; ?></td>
                                                                        <td>
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
                                                                                $badge_class = isset($status_to_class[$liquidation->item_status]) ? $status_to_class[$liquidation->item_status] : '';
                                                                            ?>
                                                                            <span class="badge <?= $badge_class; ?>">
                                                                                <?= htmlspecialchars($liquidation->desc_status); ?>
                                                                            </span>

                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- For Validation -->
                <?php if($this->session->userdata('user_type') != 2): ?>
                    <div class="mt-3">
                        <div class="accordion accordion-flush" id="forValidation">
                            <div class="accordion-item">
                                <h4 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        <div class="btn">
                                            <p class="bold"><?= ($this->session->userdata('user_type') == 3) ? 'For Validation / OTP' : 'For Validation / Pending OTP'; ?></p>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                <?php if($this->session->userdata('user_type') == 2): ?>
                                                    <?= $countLiquidationAg; ?>
                                                <?php elseif($this->session->userdata('user_type') == 3): ?>
                                                    <?= $countLiquidationA; ?>
                                                <?php elseif($this->session->userdata('user_type') == 5): ?>
                                                    <?= $countLiquidationT; ?>
                                                <?php endif; ?>
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </div>
                                    </button>
                                </h4>
                                <div id="collapseTwo" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="data-table">
                                            <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5) ? 'block' : 'none'; ?>">
                                                <table class="table table-hover " id="forValidationTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Vessel</th>
                                                            <th>Voyage</th>
                                                            <th>Port</th>
                                                            <?php if($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5): ?>
                                                                <th>Agent</th>
                                                            <?php endif; ?>
                                                            <th>Arrival</th>
                                                            <th>Departure</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if($this->session->userdata('user_type') == 2): ?>
                                                            <?php if (!empty($pending_validation)): ?>
                                                                <?php foreach ($pending_validation as $liquidation): ?>
                                                                    <?php if($liquidation->item_status == 1 || $liquidation->item_status == 2 || $liquidation->item_status == 3 || $liquidation->item_status == 5 || $liquidation->item_status == 6 || $liquidation->item_status == 7 || $liquidation->item_status == 8 ): ?>
                                                                        <tr onclick="window.location.href='<?= base_url('vesselitem/view/' . $liquidation->id); ?>'"> 
                                                                            <td><?= $liquidation->vessel_name; ?></td>
                                                                            <td><?= $liquidation->voyno; ?></td>
                                                                            <td><?= $liquidation->port; ?></td>
                                                                            <td><?= $liquidation->eta; ?></td>
                                                                            <td><?= $liquidation->etd; ?></td>
                                                                            <td>
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
                                                                                    $badge_class = isset($status_to_class[$liquidation->item_status]) ? $status_to_class[$liquidation->item_status] : '';
                                                                                ?>
                                                                                <span class="badge <?= $badge_class; ?>">
                                                                                    <?= htmlspecialchars($liquidation->desc_status); ?>
                                                                                </span>

                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?> 
                                                        <?php elseif($this->session->userdata('user_type') == 3): ?>
                                                            <?php if (!empty($pending_validation)): ?>
                                                                <?php foreach ($pending_validation as $liquidation): ?>
                                                                    <?php if($liquidation->item_status == 2): ?>
                                                                        
                                                                        <tr onclick="window.location.href='<?= base_url('agentvessel/view/' . $liquidation->id); ?>'"> 
                                                                            <td><?= $liquidation->vessel_name; ?></td>
                                                                            <td><?= $liquidation->voyno; ?></td>
                                                                            <td><?= $liquidation->port; ?></td>
                                                                            <td><?= $liquidation->supplier; ?></td>
                                                                            <td><?= $liquidation->eta; ?></td>
                                                                            <td><?= $liquidation->etd; ?></td>
                                                                            <td>
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
                                                                                    $badge_class = isset($status_to_class[$liquidation->item_status]) ? $status_to_class[$liquidation->item_status] : '';
                                                                                ?>
                                                                                <span class="badge <?= $badge_class; ?>">
                                                                                    <?= htmlspecialchars($liquidation->desc_status); ?>
                                                                                </span>

                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif ?>
                                                        <?php elseif($this->session->userdata('user_type') == 5): ?>
                                                            <?php if (!empty($pending_otp)): ?>
                                                                <?php foreach ($pending_otp as $liquidation): ?>
                                                                    <?php if($liquidation->item_status == 1): ?>    
                                                                        <tr onclick="window.location.href='<?= base_url('agentvessel/view/' . $liquidation->id); ?>'"> 
                                                                            <td><?= $liquidation->vessel_name; ?></td>
                                                                            <td><?= $liquidation->voyno; ?></td>
                                                                            <td><?= $liquidation->port; ?></td>
                                                                            <td><?= $liquidation->supplier; ?></td>
                                                                            <td><?= $liquidation->eta; ?></td>
                                                                            <td><?= $liquidation->etd; ?></td>
                                                                            <td>
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
                                                                                $badge_class = isset($status_to_class[$liquidation->item_status]) ? $status_to_class[$liquidation->item_status] : '';
                                                                            ?>
                                                                            <span class="badge <?= $badge_class; ?>">
                                                                                <?= htmlspecialchars($liquidation->desc_status); ?>
                                                                            </span>

                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Completed Liquidation -->
                <div class="mt-3" style="display: <?= ($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 2) ? 'block' : 'none'; ?>">
                    <div class="accordion accordion-flush" id="completed">
                        <div class="accordion-item">
                            <h4 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    <div class="btn">
                                        <p class="bold">Completed Liquidation</p>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <?php if($this->session->userdata('user_type') == 2): ?>
                                                <?= $countCompletedAg; ?>
                                            <?php elseif($this->session->userdata('user_type') == 3): ?>
                                                <?= $countCompleted; ?>
                                            <?php endif; ?>
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </div>
                                </button>
                            </h4>
                            <div id="collapseFour" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="data-table">
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 2 || $this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5) ? 'block' : 'none'; ?>">
                                            <table class="table table-hover " id="completedTable">
                                                <thead>
                                                    <tr>
                                                        <th>Vessel</th>
                                                        <th>Voyage</th>
                                                        <th>Port</th>
                                                        <?php if($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5): ?>
                                                            <th>Agent</th>
                                                        <?php endif; ?>
                                                        <th>Arrival</th>
                                                        <th>Departure</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if($this->session->userdata('user_type') == 2): ?>
                                                        <?php if (!empty($completed)): ?>
                                                            <?php foreach ($completed as $liquidation): ?>
                                                                <?php if($liquidation->item_status == '4'): ?>
                                                                    <tr onclick="window.location.href='<?= base_url('vesselitem/view/' . $liquidation->id); ?>'"> 
                                                                        <td><?= $liquidation->vessel_name; ?></td>
                                                                        <td><?= $liquidation->voyno; ?></td>
                                                                        <td><?= $liquidation->port; ?></td>
                                                                        <td><?= $liquidation->eta; ?></td>
                                                                        <td><?= $liquidation->etd; ?></td>
                                                                        <td>
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
                                                                            $badge_class = isset($status_to_class[$liquidation->item_status]) ? $status_to_class[$liquidation->item_status] : '';
                                                                        ?>
                                                                        <span class="badge <?= $badge_class; ?>">
                                                                            <?= htmlspecialchars($liquidation->desc_status); ?>
                                                                        </span>

                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                        <?php elseif($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5): ?>
                                                            <?php if (!empty($completed)): ?>
                                                                <?php foreach ($completed as $liquidation): ?>
                                                                    <?php if($liquidation->item_status == '4'): ?>
                                                                    <tr onclick="window.location.href='<?= base_url('agentvessel/view/' . $liquidation->id); ?>'"> 
                                                                        <td><?= $liquidation->vessel_name; ?></td>
                                                                        <td><?= $liquidation->voyno; ?></td>
                                                                        <td><?= $liquidation->port; ?></td>
                                                                        <td><?= $liquidation->supplier; ?></td>
                                                                        <td><?= $liquidation->eta; ?></td>
                                                                        <td><?= $liquidation->etd; ?></td>
                                                                        <td>
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
                                                                            $badge_class = isset($status_to_class[$liquidation->item_status]) ? $status_to_class[$liquidation->item_status] : '';
                                                                        ?>
                                                                        <span class="badge <?= $badge_class; ?>">
                                                                            <?= htmlspecialchars($liquidation->desc_status); ?>
                                                                        </span>

                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- For Revalidation / For Amendment -->
                <div class="mt-3" style="display: <?= ($this->session->userdata('user_type') == 2) ? 'block' : 'none'; ?>">
                    <div class="accordion accordion-flush" id="revalidated">
                        <div class="accordion-item">
                            <h4 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    <div class="btn">
                                        <p class="bold"><?= ($this->session->userdata('user_type') == 2) ? 'For Amendment' : 'Return To Agent'; ?></p>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <?php if($this->session->userdata('user_type') == 2): ?>
                                                <?= $countRevalidatedAg; ?>
                                            <?php elseif($this->session->userdata('user_type') == 3): ?>
                                                <?= $countRevalidatedA; ?>
                                            <?php elseif($this->session->userdata('user_type') == 5): ?>
                                                <?= $countRevalidatedT; ?>
                                            <?php endif; ?>
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </div>
                                </button>
                            </h4>
                            <div id="collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="data-table">
                                        <div class="table-responsive" style="display: <?= ($this->session->userdata('user_type') == 2 || $this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5) ? 'block' : 'none'; ?>">
                                            <table class="table table-hover " id="revalidatedTable">
                                                <thead>
                                                    <tr>
                                                        <th>Vessel</th>
                                                        <th>Voyage</th>
                                                        <th>Port</th>
                                                        <?php if($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 5): ?>
                                                            <th>Agent</th>
                                                        <?php endif; ?>
                                                        <?php if($this->session->userdata('user_type') == 2): ?>
                                                            <th>Arrival</th>
                                                            <th>Departure</th>
                                                        <?php endif; ?>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if($this->session->userdata('user_type') == 2): ?>
                                                        <?php if (!empty($for_amendment)): ?>
                                                            <?php foreach ($for_amendment as $liquidation): ?>
                                                                <?php if($liquidation->item_status == '5' || $liquidation->item_status == '6' || $liquidation->item_status == '7' || $liquidation->item_status == '8'): ?>
                                                                    <tr onclick="window.location.href='<?= base_url('vesselitem/view/' . $liquidation->id); ?>'"> 
                                                                    <td><?= $liquidation->vessel_name; ?></td>
                                                                    <td><?= $liquidation->voyno; ?></td>
                                                                    <td><?= $liquidation->port; ?></td>
                                                                    <td><?= $liquidation->eta; ?></td>
                                                                    <td><?= $liquidation->etd; ?></td>
                                                                    <td>
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
                                                                            $badge_class = isset($status_to_class[$liquidation->item_status]) ? $status_to_class[$liquidation->item_status] : '';
                                                                        ?>
                                                                        <span class="badge <?= $badge_class; ?>">
                                                                            <?= htmlspecialchars($liquidation->desc_status); ?>
                                                                        </span>

                                                                        </td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php endif ?>
                                                    <?php elseif($this->session->userdata('user_type') == 3): ?>
                                                        <?php if (!empty($for_amendment)): ?>
                                                            <?php foreach ($for_amendment as $liquidation): ?>
                                                                <?php if($liquidation->item_status == '5' || $liquidation->item_status == '7' || $liquidation->item_status == '8'): ?>
                                                                    <tr onclick="window.location.href='<?= base_url('agentvessel/view/' . $liquidation->id); ?>'"> 
                                                                        <td><?= $liquidation->vessel_name; ?></td>
                                                                        <td><?= $liquidation->voyno; ?></td>
                                                                        <td><?= $liquidation->port; ?></td>
                                                                        <td><?= $liquidation->supplier; ?></td>
                                                                        <td>
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

                                                                                $badge_class = isset($status_to_class[$liquidation->item_status]) ? $status_to_class[$liquidation->item_status] : '';
                                                                            ?>
                                                                            <span class="badge <?= $badge_class; ?>">
                                                                                <?= htmlspecialchars($liquidation->desc_status); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php elseif($this->session->userdata('user_type') == 5): ?>
                                                        <?php if (!empty($for_amendment)): ?>
                                                            <?php foreach ($for_amendment as $liquidation): ?>
                                                                <?php if($liquidation->item_status == '5' || $liquidation->item_status == '6' || $liquidation->item_status == '7' || $liquidation->item_status == '8'): ?>
                                                                    <tr onclick="window.location.href='<?= base_url('agentvessel/view/' . $liquidation->id); ?>'"> 
                                                                        <td><?= $liquidation->vessel_name; ?></td>
                                                                        <td><?= $liquidation->voyno; ?></td>
                                                                        <td><?= $liquidation->port; ?></td>
                                                                        <td><?= $liquidation->supplier; ?></td>
                                                                        <td>
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
                                                                            $badge_class = isset($status_to_class[$liquidation->item_status]) ? $status_to_class[$liquidation->item_status] : '';
                                                                        ?>
                                                                        <span class="badge <?= $badge_class; ?>">
                                                                            <?= htmlspecialchars($liquidation->desc_status); ?>
                                                                        </span>

                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
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
    <?php if($this->session->userdata('usertype') != 1): ?>
        <?php $this->load->view('partials/breakdown-window'); ?>
    <?php endif; ?>

    <script>
        function toggleBreakdown() {
            const chat = document.querySelector('.breakdown-window');
            chat.classList.toggle('open');
        }
        $(document).ready(function() {
            
            var unliquidatedTable = $('#unliquidatedTable').DataTable({
                paging: true,
                searching: true,
                pageLength: 5,
                order: [],
                initComplete: function(settings, json) {
                    $('#unliquidatedTable').attr('id', 'unliquidatedTableSearch'); 
                }
            });
            var forValidationTable = $('#forValidationTable').DataTable({
                paging: true,
                searching: true,
                pageLength: 5,
                order: []
            });
            var revalidatedTable = $('#revalidatedTable').DataTable({
                paging: true,
                searching: true,
                pageLength: 5,
                order: []
            });
            var completedTable = $('#completedTable').DataTable({
                paging: true,
                searching: true,
                pageLength: 5,
                order: []
            });
            var forAMValidationTable = $('#forAMValidationTable').DataTable({
                paging: true,
                searching: true,
                pageLength: 5,
                order: []
            });
            var forSettlementTable = $('#forSettlementTable').DataTable({
                paging: true,
                searching: true,
                pageLength: 5,
                order: []
            });

            $('#unliquidatedTable').attr('id', 'unliquidatedTableSearch');

            
            
        });
    </script>

</body>
</html>
