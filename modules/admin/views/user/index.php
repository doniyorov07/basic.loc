<?php

/**
 * @var \app\models\User $model
 */
?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Username</th>
        <th scope="col">Status</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php foreach ($model as $item):?>
        <td><?=$item->username?></td>
        <td><?=$item->status?></td>
        <?php endforeach;?>
    </tr>
    </tbody>
</table>