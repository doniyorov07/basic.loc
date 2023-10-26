<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var app\models\Tag $tegs */
/** @var app\models\Category $cets */

$this->title = 'Post yaratish';
$this->params['breadcrumbs'][] = ['label' => 'Post', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
