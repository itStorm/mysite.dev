<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/**
 * @var app\modules\user\models\GetConfirmationLinkForm $model
 */
?>


<div class="user-email-confirm">
    <?php if (Yii::$app->session->hasFlash('sentNewConfirmationLink')): ?>

        <div class="alert alert-info">
            Check your mail. We sent new link!
        </div>

    <?php else: ?>

        <?php if (Yii::$app->session->hasFlash('errorActivationCode')): ?>

            <div class="alert alert-danger">
                Sorry! Bad link, try get another link.
            </div>
        <?php endif; ?>

        <h1>Get again confirmation link</h1>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'registration-form']); ?>

                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'captchaAction' => '/user/default/captcha',
                    'template'      => '<div class="row"><div class="col-lg-6">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php endif; ?>

</div>