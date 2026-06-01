<?php

/** @var $model app\models\Claims */
/** @var $details app\models\ClaimDetails[] */
?>

<table class="table table-bordered table-sm">
    <thead class="table-light">
        <tr>
            <th>History Type</th>
            <th>Trans Date</th>
            <th>Description</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($details as $d): ?>
            <tr>
                <td><?= $d->history_type ?></td>
                <td><?= $d->trans_date ?></td>
                <td><?= $d->description ?></td>
                <td><?= $d->item_name ?></td>
                <td><?= $d->quantity ?></td>
                <td><?= $d->unit_price ?></td>
                <td><?= $d->total ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>