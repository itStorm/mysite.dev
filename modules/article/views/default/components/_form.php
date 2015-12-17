<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use common\libs\fileuploader\assets\TinyMCEAsset;
use app\modules\user\models\User;
use common\widgets\TagsInputWidget;
use common\libs\safedata\SafeDataFinder;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\ArticleEditForm */
/* @var $form yii\widgets\ActiveForm */

TinyMCEAsset::register($this);
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3, 'maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'form-control wisywyg-editor']) ?>

    <?= $form->field($model, 'published_date')->widget(DateControl::classname(), ['type' => DateControl::FORMAT_DATETIME]) ?>

    <?= $form->field($model, 'pseudo_alias')->textInput(['maxlength' => true]) ?>

    <?php
    $fileWidgetOptions = [
        'class' => 'olololo',
        'pluginOptions' => [
            'showPreview'          => true,
            'showCaption'          => true,
            'showRemove'           => true,
            'showUpload'           => false,
        ]
    ];

    if ($fileLogo = $model->getModel()->getUrlLogoImageFile(true)) {
        $fileWidgetOptions['pluginOptions']['initialPreview'] = [
            Html::img($fileLogo, ['class' => 'file-preview-image', 'alt' => 'Logo', 'title' => 'Logo']),
        ];
    }
    echo $form->field($model, 'logo_file')->widget(FileInput::className(), $fileWidgetOptions);

    $classLogoFile = 'field-'.Html::getInputId($model, 'logo_file');
    $idDeleteLogoFile = Html::getInputId($model, 'delete_logo_file');
    $js = <<<JS
    $('.{$classLogoFile} .fileinput-remove').bind('click', function(){
        $('#{$idDeleteLogoFile}').val(1);
    });
JS;
    $this->registerJs($js);
    ?>

    <?= $form->field($model, 'delete_logo_file')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= TagsInputWidget::widget(['model' => $model, 'attribute' => 'tags']); ?>
    </div>

    <?= $form->field($model, 'seo_description')->textarea() ?>

    <?= $form->field($model, 'seo_keywords')->textarea() ?>

    <?= $form->field($model, SafeDataFinder::FIELD_IS_ENABLED)->checkbox() ?>

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
