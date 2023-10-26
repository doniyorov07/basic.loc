<?php


use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\switchinput\SwitchInput;
use app\widgets\Alert;
/** @var yii\data\ActiveDataProvider $model */
/** @var yii\data\ActiveDataProvider $tag */
?>
<?= Alert::widget()?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tag qo'shish</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <?= $form->field($model, 'name')->textInput() ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'status')->widget(SwitchInput::classname(), [
                                'pluginOptions' => [
                                    'size' => 'large',
                                    'onColor' => 'success',
                                    'offColor' => 'danger',
                                    'onText' => "On",
                                    'offText' => "Off",
                                ]
                            ])?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>

            </div>

            <!-- /.col -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Taglar</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Tag nomi</th>
                                <th></th>
                                <th>Holati</th>
                                <th></th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tag as $key) : ?>
                                <tr>
                                    <td><?= $key->name ?></td>
                                    <td></td>
                                    <td>
                                        <?php
                                        if ($key->status == 1) {
                                            echo Html::a('<i class="badge badge-success">Faol</i>', ['change', 'id' => $key  ->id]);
                                        } else {
                                            echo Html::a('<i class="badge badge-danger">Faol emas</i>', ['change', 'id' => $key  ->id]);
                                        }
                                        ?>
                                    </td>
                                    <td></td>
                                    <td>
                                        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $key->id], [
                                            'data' => [
                                                'confirm' => 'Haqiqatdan tagni o\'chirmoqchimisiz!',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                        <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['update', 'id' => $key->id], [
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>

