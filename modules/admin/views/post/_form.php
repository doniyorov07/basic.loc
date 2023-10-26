<?php

use app\models\Tag;
use app\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;




/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\widgets\ActiveForm $data *//** @var app\models\Tag $tegs */
/** @var app\models\Category $cets */

$selectedTags = ArrayHelper::getColumn($model->tags, 'name');
$selectedCategories = ArrayHelper::getColumn($model->categories, 'name');
?>

<?php $form = ActiveForm::begin(); ?>
<div class="post-form row">
        <div class="col-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>
        </div>
    <div class="col-6">
        <?= $form->field($model, 'category_id')->widget(Select2::className(), [
            'name' => 'color_2',
            'value' => $selectedCategories,
            'data' => $data = ArrayHelper::map(Category::find()->where(['status' => 1])->all(), 'id', 'name'),
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Categorylarni tanlang', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 15
            ],
        ])->label('Categorylar') ?>
    </div>
      <div class="col-6">
          <?= $form->field($model, 'tag_id')->widget(Select2::className(), [
              'name' => 'color_2',
              'value' =>$selectedTags,
              'data' => $data = ArrayHelper::map(Tag::find()->where(['status' => 1])->all(), 'id', 'name'),
              'maintainOrder' => true,
              'options' => ['placeholder' => 'Taglarni tanglang', 'multiple' => true],
              'pluginOptions' => [
                  'tags' => true,
                  'maximumInputLength' => 15
              ],
          ])->label('Taglar') ?>
      </div>

    <div class="col-6">
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
        <div style="padding-top: 32px" class="col-6">
            <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
        </div>
</div>
<?php ActiveForm::end(); ?>





