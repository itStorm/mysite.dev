<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\modules\user\models\User;

/* @var $this common\View */
/* @var $content string */
?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>

<div class="wrap">
    <div class="navbar-wrapper">
        <div class="container">
            <?php

            $navBarItems = [Yii::$app->user->isGuest ?
                ['label' => Yii::t('app', 'Login'),
                 'url'   => ['/user/default/login']] :
                ['label' => '<span class="glyphicon glyphicon-user"></span> ' . Html::encode(Yii::$app->user->identity->username),
                 'url'   => ['/user']],
                Yii::$app->user->isGuest ? '' :
                    ['label'       => '<span class="glyphicon glyphicon-off"></span>',
                     'url'         => ['/user/default/logout'],
                     'linkOptions' => ['data-method' => 'post']],
            ];

            if (Yii::$app->user->can(User::ROLE_NAME_ADMIN)) {
                $navBarItems = array_merge([
                    ['label' => Yii::t('app', 'Home'), 'url' => ['/main/default/index']],
                    ['label' => Yii::t('app', 'About'), 'url' => ['/main/default/about']],
                ], $navBarItems);
            }

            NavBar::begin([
                'brandLabel' => Yii::$app->params['projectName'],
                'brandUrl'   => Yii::$app->homeUrl,
                'options'    => [
                    'class' => 'navbar-inverse  navbar-static-top',
                ],
            ]);
            echo Nav::widget([
                'options'      => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items'        => $navBarItems]);
            NavBar::end();
            ?>
        </div>
    </div>

    <div class="container">
        <?= isset($this->blocks['before_content'])? $this->blocks['before_content'] : ''; ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= $content ?>

    </div>
</div>

<footer class="footer">
    <div class="container">
        <?= Html::a(Yii::t('app', 'Contact us'), ['/main/default/contact'], ['class' => ['link-no-decorate']]); ?>
        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Agreement'), ['/main/default/agreement'], ['class' => ['link-no-decorate']]); ?>
            &nbsp;&nbsp;&copy; <?= Yii::$app->params['projectName'] ?> <?= date('Y') ?>
        </p>
    </div>
</footer>

<?php $this->endContent(); ?>
