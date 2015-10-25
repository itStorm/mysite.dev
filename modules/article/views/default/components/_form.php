<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\assets\TinyMCEAsset;
use app\modules\user\models\User;
use common\widgets\TagsWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Article */
/* @var $form yii\widgets\ActiveForm */

TinyMCEAsset::register($this);
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'form-control wisywyg-editor']) ?>

    <?= $form->field($model, 'created')->widget(DateControl::classname(), ['type' => DateControl::FORMAT_DATETIME]) ?>

    <?= $form->field($model, 'updated')->widget(DateControl::classname(), ['type' => DateControl::FORMAT_DATETIME]) ?>

    <?= $form->field($model, 'is_enabled')->checkbox() ?>

    <div class="form-group">
        <?= TagsWidget::widget(['model' => $model, 'attribute' => 'tags']); ?>
    </div>

    <?php
    if (Yii::$app->user->can(User::ROLE_NAME_ADMIN)) {
        echo $form->field($model, 'is_deleted')->checkbox();
    }
    ?>


    <div class="form-group">
        <?= Html::submitButton(!$model->id ? 'Create' : 'Update', ['class' => !$model->id ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
