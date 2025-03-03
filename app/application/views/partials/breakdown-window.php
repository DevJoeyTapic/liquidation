
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
                <p class="p-0">PHP</p>
                <p class="p-0">USD</p>
                <div class="ball"></div>
                </label>
            </div>
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
<script>
    $(document).ready(function() {
        const checkbox = document.getElementById('chk');
        const label = document.querySelector('.breakdown-window .label');

        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
            label.classList.remove('bg-success');
            label.classList.add('bg-primary');
            } else {
            label.classList.remove('bg-primary');
            label.classList.add('bg-success');
            }
        });
    });
</script>