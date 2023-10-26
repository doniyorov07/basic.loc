<?php


/** @var yii\web\View $detail */


?>

<div class="card">
    <div class="card-header">
        Post
    </div>
    <div class="card-body">
        <h5 class="card-title"><?=$detail->title?></h5>
        <p class="card-text"><?=$detail->text?></p>
    </div>
</div>


<br>
<br>
<br>
<br>
<br>
<div class="row">
    <?php foreach ($detail->tags as $item) :?>
    <div class="col-sm-6">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?=$item->name?></h5>
                    <a href="<?= \yii\helpers\Url::to(['tags', 'id' => $item->id])?>" class="btn btn-primary">Ba'tafsil</a>
                </div>
            </div>
    </div>
    <?php endforeach;?>
</div>
<br>
<br>
<div class="row">
<?php foreach ($detail->categories as $item) :?>
    <div class="col-sm-6">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?=$item->name?></h5>
                <a href="<?= \yii\helpers\Url::to(['categories', 'id' => $item->id])?>" class="btn btn-primary">Ba'tafsil</a>
            </div>
        </div>
    </div>
<?php endforeach;?>
</div>
