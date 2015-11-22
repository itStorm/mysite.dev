<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use common\libs\fileuploader\assets\TinyMCEAsset;
use app\modules\user\models\User;
use common\widgets\TagsInputWidget;
use common\libs\safedata\SafeDataFinder;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Article */
/* @var $form yii\widgets\ActiveForm */

TinyMCEAsset::register($this);
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3, 'maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'form-control wisywyg-editor']) ?>

    <?= $form->field($model, 'published_date')->widget(DateControl::classname(), ['type' => DateControl::FORMAT_DATETIME]) ?>

    <?= $form->field($model, 'pseudo_alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, SafeDataFinder::FIELD_IS_ENABLED)->checkbox() ?>

    <div class="form-group">
        <?= TagsInputWidget::widget(['model' => $model, 'attribute' => 'tags']); ?>
    </div>

    <?php
    if (Yii::$app->user->can(User::ROLE_NAME_ADMIN)) {
        echo $form->field($model, SafeDataFinder::FIELD_IS_DELETED)->checkbox();
    }
    ?>


    <div class="form-group">
        <?= Html::submitButton(!$model->id ? 'Create' : 'Update', ['class' => !$model->id ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
