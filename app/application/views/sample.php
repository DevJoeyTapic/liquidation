<div>
    <?php foreach($breakdown_cost as $cost): ?>
        <pre>
            <?= $cost->id; ?>
            <?= $cost->item_id; ?>
            <?= $cost->description; ?>
            <?= $cost->currency; ?>
            <?= $cost->rfp_amount; ?>
            <?= $cost->variance; ?>
        </pre>
    <?php endforeach; ?>
</div>