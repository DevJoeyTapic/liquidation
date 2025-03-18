
<button onclick="toggleBreakdown()" class="breakdown-toggle-btn btn btn-warning rounded-circle">
    <i class="fa-solid fa-money-bill-transfer"></i>
</button>
<div class="breakdown-window">
    <div class="breakdown-header text-white p-3 text-center">
        Credit Breakdown
    </div>
    <div class="breakdown-content p-3">                        
        <div class="d-flex justify-content-between align-items-end mb-2">
            <h4><strong>Credit Breakdown:</strong></h4>
            
            <div class="one-quarter" id="switch">
                <input type="checkbox" class="checkbox" id="chk" checked/>
                <label class="label" for="chk">
                
                <i class="fa-solid fa-peso-sign ps-1"></i>
                <i class="fa-solid fa-dollar-sign pe-1"></i>
                
                <div class="ball"></div>
                </label>
            </div>

        </div>
        <table class="table table-warning table-hover" id="creditBreakdown">
            <caption class="small">As of <span id="currentTime"><?php echo date('Y-m-d H:i:s', strtotime('+8 hours')); ?></span></caption>
            <thead>
                <tr>
                    <?php if($this->session->userdata('user_type') == '3' || $this->session->userdata('user_type') == '5'): ?>
                    <th>Agent</th>
                    <?php endif; ?>
                    <th>Vessel/Voyage</th>
                    <th class="text-center">Due Wallem</th>
                    <th class="text-center">Due Agent</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($credit_breakdown as $credit): ?>
                    <tr>
                        <?php if($this->session->userdata('user_type') == '3' || $this->session->userdata('user_type') == '5'): ?>
                        <td><?= $credit->supplier; ?></td>
                        <?php endif; ?>
                        <td><?= $credit->vessel_name . ' ' . $credit->voyno; ?></td>
                        <td class="text-end">
                            <span class="currency-content" id="dueWallemUSD"><?= number_format($credit->due_wallem_usd, 2); ?></span>
                            <span class="currency-content d-none" id="dueWallemPHP"><?= number_format($credit->due_wallem_php, 2); ?></span>
                        </td>
                        <td class="text-end">
                            <span class="currency-content" id="dueAgentUSD"><?= number_format($credit->due_agent_usd, 2); ?></span>
                            <span class="currency-content d-none" id="dueAgentPHP"><?= number_format($credit->due_agent_php, 2); ?></span>
                        </td>

                    </tr>
                <? endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-light text-end">
                    <?php if($this->session->userdata('user_type') == '3' || $this->session->userdata('user_type') == '5'): ?>
                    <td></td>
                    <?php endif; ?>
                    <td></td>
                    <td class="bold text-end">
                        <span id="totalWallemPHP" class="d-none"><span class="switchCur">USD</span>&nbsp;<?= number_format($total_php->total_due_wallem_php, 2); ?></span>
                        <span id="totalWallemUSD"><span class="switchCur">USD</span>&nbsp;<?= number_format($total_usd->total_due_wallem_usd, 2); ?></span>
                    </td>
                    <td class="bold text-end">
                        <span id="totalAgentPHP" class="d-none"><span class="switchCur">USD</span>&nbsp;<?= number_format($total_php->total_due_agent_php, 2); ?></span>
                        <span id="totalAgentUSD"><span class="switchCur">USD</span>&nbsp;<?= number_format($total_usd->total_due_agent_usd, 2); ?></span>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="d-flex justify-content-between">
            <div class="col">
                <h6 class="text-end bold">

                </h6>
            </div>
            <div class="col">
                <h6 class="text-end bold">
                    
                </h6>
            </div>
        </div>
        <hr>
        <div class="col">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4><strong>Outstanding Balance:</strong></h4>
                <i class="fa-solid fa-circle-info" data-toggle="collapse" data-target="#info" aria-expanded="false" aria-controls="info"></i>
            </div>
            <div class="collapse" id="info">
                <div class="p-1">
                    <p class="text-warning">The list below shows the total amount for each vessel with controlled items that have not yet been released, which will be released once the service is completed.</p>
                </div>
            </div>
            <table class="table table-warning table-hover" id="dueControlled">
                <thead>
                    <tr>
                        <?php if($this->session->userdata('user_type') == '3' || $this->session->userdata('user_type') == '5'): ?>
                        <th>Agent</th>
                        <?php endif; ?>
                        <th>Vessel / Voyage</th>
                        <th>Requested Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($due_agent_controlled as $controlled): ?>
                        <tr>
                            <?php if($this->session->userdata('user_type') == '3' || $this->session->userdata('user_type') == '5'): ?>
                            <td><?= $controlled->supplier; ?></td>
                            <?php endif; ?>
                            <td><?= $controlled->vessel_name . '&nbsp;' . $controlled->voyno ?></td>
                            <td class="text-end"><?= number_format($controlled->requested, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-light text-end">
                        <?php if($this->session->userdata('user_type') == '3' || $this->session->userdata('user_type') == '5'): ?>
                        <td></td>
                        <?php endif; ?>
                        <td></td>
                        <td class="bold text-end">
                            <span><?= number_format($all_controlled_total->controlled_requested, 2); ?></span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    const checkbox = document.getElementById('chk');
    const label = document.querySelector('.breakdown-window .label');
    const switchCurElements = document.querySelectorAll('.switchCur');
    const totalWallemPHP = document.getElementById('totalWallemPHP');
    const totalWallemUSD = document.getElementById('totalWallemUSD');
    const totalAgentPHP = document.getElementById('totalAgentPHP');
    const totalAgentUSD = document.getElementById('totalAgentUSD');
    const dueWallemPHP = document.getElementById('dueWallemPHP');
    const dueWallemUSD = document.getElementById('dueWallemUSD');
    const dueAgentPHP = document.getElementById('dueAgentPHP');
    const dueAgentUSD = document.getElementById('dueAgentUSD');

    // Function to toggle between PHP and USD
    const toggleCurrency = (isChecked) => {
        // Toggle label background
        label.classList.toggle('bg-primary', isChecked);
        label.classList.toggle('bg-success', !isChecked);

        const usdContent = document.querySelectorAll('#dueWallemUSD , #dueAgentUSD ');
        const phpContent = document.querySelectorAll('#dueWallemPHP , #dueAgentPHP ');

        // Toggle visibility of PHP and USD elements
        totalWallemPHP.classList.toggle('d-block', isChecked);
        totalWallemPHP.classList.toggle('d-none', !isChecked);
        totalWallemUSD.classList.toggle('d-block', !isChecked);
        totalWallemUSD.classList.toggle('d-none', isChecked);

        totalAgentPHP.classList.toggle('d-block', isChecked);
        totalAgentPHP.classList.toggle('d-none', !isChecked);
        totalAgentUSD.classList.toggle('d-block', !isChecked);
        totalAgentUSD.classList.toggle('d-none', isChecked);

        usdContent.forEach(element => {
            element.classList.toggle('d-none', isChecked);
        });

        phpContent.forEach(element => {
            element.classList.toggle('d-none', !isChecked);
        });

        // Update currency label
        switchCurElements.forEach(element => {
            element.textContent = isChecked ? 'PHP' : 'USD';
        });
    };

    // Initial state (based on checkbox checked or not)
    toggleCurrency(checkbox.checked);

    // Event listener for checkbox change
    checkbox.addEventListener('change', function () {
        toggleCurrency(checkbox.checked);
    });
});

</script>
<script>
    $(document).ready(function() {
        var creditBreakdown = $("#creditBreakdown").DataTable({
            paging: true,
            searching: true,
            pageLength: 5,
            order: []
        });
        var dueControlled = $("#dueControlled").DataTable({
            paging: true,
            searching: true,
            pageLength: 5,
            order: []
        });
    })
</script>