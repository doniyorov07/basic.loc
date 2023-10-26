<?php

/** @var yii\web\View $this */
/** @var yii\web\View $model */

$this->title = 'My Yii Application';

?>

<div class="row">
        <?php foreach ($model as $item) :?>
    <div class="col-sm-6">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?=$item->title?></h5>
                    <a href="<?=\yii\helpers\Url::to(['detail', 'id' => $item->id])?>" class="btn btn-primary">Ba'tafsil</a>
                </div>
            </div>
    </div>
        <?php endforeach;?>
</div>


<div class="site-index">

</div>
