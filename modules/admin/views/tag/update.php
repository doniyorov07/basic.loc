<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/** @var yii\data\ActiveDataProvider $model */
?>

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
