<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\user\models\LoginForm */

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php if (Yii::$app->session->hasFlash('userNotActivate')): ?>

        <div class="alert alert-warning">
            Аккаунт не активирован. Вам необходимо <?= Html::a('подвердить email', ['/user/default/get-confirmation-link']); ?> по ссылке в письме.
        </div>

    <?php elseif(Yii::$app->session->hasFlash('userIsDeleted')): ?>

        <div class="alert alert-danger">
            Account blocked!
        </div>

    <?php endif; ?>

    <div class="h1"><?= Html::encode($this->title) ?></div>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="col-lg-offset-1 col-lg-3">
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
    </div>


    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            &nbsp;&nbsp;&nbsp;
            <?= Html::a(Yii::t('app', 'Registration'), ['/user/default/registration'])?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
