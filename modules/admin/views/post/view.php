<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\Alert;
/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = 'Post';
$this->params['breadcrumbs'][] = ['label' => 'Post', 'url' => ['index']];

?>
<?= Alert::widget()?>
<div class="post-view">
    <p>
        <?= Html::a('Tahrirlash', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('O\'chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Haqiqatdan ham postni o\'chirmoqchimisiz?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'title',
            'text',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model){
                    if ($model->status === 1){
                        return '<i class="badge badge-success">Faol</i>';
                    }else{
                        return '<i class="badge badge-danger">Faol emas</i>';
                    }
                }
            ],
        ],
    ]) ?>

</div>
