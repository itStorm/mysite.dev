<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <div class="navbar-wrapper">
            <div class="container">
            <?php
                NavBar::begin([
                    'brandLabel' => Yii::$app->params['projectName'],
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-inverse  navbar-static-top',
                    ],
                ]);
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
                        ['label' => Yii::t('app', 'Home'), 'url' => ['/main/default/index']],
                        ['label' => Yii::t('app', 'About'), 'url' => ['/main/default/about']],
                        ['label' => Yii::t('app', 'Contact'), 'url' => ['/main/default/contact']],
                        Yii::$app->user->isGuest ?
                            ['label' => Yii::t('app', 'Login'), 'url' => ['/user/default/login']] :
                            ['label' => Yii::t('app', 'Logout ({username})', ['username' => Yii::$app->user->identity->username ]),
                                'url' => ['/user/default/logout'],
                                'linkOptions' => ['data-method' => 'post']],
                    ],
                ]);
                NavBar::end();
            ?>
            </div>
         </div>

        <div class="container">
            <?= $this->blocks['before_content']; ?>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <?= $content ?>
                </div>
                <div class="col-sm-2 col-sm-offset-1">
                    <?= $this->blocks['sidebar'] ;?>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-right">&copy; <?= Yii::$app->params['projectName'] ?> <?= date('Y') ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
