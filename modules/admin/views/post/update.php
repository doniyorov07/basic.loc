<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = 'Postni tahrirlash';
$this->params['breadcrumbs'][] = ['label' => 'Post', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Tahrirlash';
?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
