<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\banner\models\BannerArea;

/* @var $this yii\web\View */
/* @var $model app\modules\banner\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'area_id')->dropDownList(
        BannerArea::find()->select(['name', 'id'])->indexBy('id')->column(),
        ['prompt' => 'Select area for placement']
    ); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
