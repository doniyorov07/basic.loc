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
    <?php foreach ($model as $item):?>
    <tr>
            <td><?=$item->username?></td>
            <td><?php
                if ($item->status == 10)
                {
                    echo '<i class="badge badge-success">Faol</i>';
                }else
                {
                    echo '<i class="badge badge-danger">Faol emas</i>';
                }

                ?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>