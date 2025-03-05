
<button onclick="toggleBreakdown()" class="breakdown-toggle-btn btn btn-warning rounded-circle">
    <i class="fa-solid fa-money-bill-transfer"></i>
</button>
<div class="breakdown-window">
    <div class="breakdown-header text-white p-3 text-center">
        Credit Breakdown
    </div>
    <div class="breakdown-content p-3">                        
        <div class="d-flex justify-content-between align-items-end">
            <h4><strong>Credit Breakdown:</strong></h4>
            
            <div class="one-quarter" id="switch">
                <input type="checkbox" class="checkbox" id="chk" />
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
                    <th>Vessel/Voyage</th>
                    <th>Balance Due Wallem</th>
                    <th>Balance Due Agent</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($credit_breakdown as $credit): ?>
                    <tr>
                        <td><?= $credit->vessel_name . ' ' . $credit->voyno; ?></td>
                        <td >
                            <span class="currency-content" id="dueWallemUSD"><?= number_format($credit->due_wallem_usd, 2); ?></span>
                            <span class="currency-content d-none" id="dueWallemPHP"><?= number_format($credit->due_wallem_php, 2); ?></span>
                        </td>
                        <td>
                            <span class="currency-content" id="dueAgentUSD"><?= number_format($credit->due_agent_usd, 2); ?></span>
                            <span class="currency-content d-none" id="dueAgentPHP"><?= number_format($credit->due_agent_php, 2); ?></span>
                        </td>

                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <div class="col"></div>
            <div class="col">
                <h5 class="text-end bold">
                    
                    <span id="totalWallemPHP" class="d-none"><span class="switchCur">USD</span>&nbsp;<?= number_format($total_php->total_due_wallem_php, 2); ?></span>
                    <span id="totalWallemUSD"><span class="switchCur">USD</span>&nbsp;<?= number_format($total_usd->total_due_wallem_usd, 2); ?></span>

                </h5>
            </div>
            <div class="col">
                <h5 class="text-end bold">
                    
                    <span id="totalAgentPHP" class="d-none"><span class="switchCur">USD</span>&nbsp;<?= number_format($total_php->total_due_agent_php, 2); ?></span>
                    <span id="totalAgentUSD"><span class="switchCur">USD</span>&nbsp;<?= number_format($total_usd->total_due_agent_usd, 2); ?></span>
                </h5>
            </div>
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