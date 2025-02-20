<?php if ($this->session->userdata('user_type') == 2): ?>
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
<?php endif; ?>

