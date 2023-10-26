<?php

use app\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\widgets\Alert;


/** @var yii\web\View $this */
/** @var app\models\search\Post $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Post';

?>
<?= Alert::widget()?>
<div class="post-index">

    <br>
    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true">Qo\'shish</i>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'text',
            [
                'attribute' => 'Taglar',
                'format' => 'raw',
                'value' => function($model) {
                    $tagString = '';
                    foreach ($model->tags as $tag) {
                        $tagString .= '<i class="badge badge-warning">' . $tag->name . '</i> ';
                    }
                    return $tagString;
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model){
                    if ($model->status == 1){
                        return '<i class="badge badge-success">Faol</i>';
                    }else{
                        return '<i class="badge badge-danger">Faol emas</i>';
                    }
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
