<?php

use yii\helpers\Html;
use app\modules\article\models\Article;
use common\widgets\SocialButtonsWidget;
use yii\helpers\Url;
use common\widgets\SocialCommentWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$mainUrl = $model->getUrlView(true, true);

$adminButtons = '';
if (Yii::$app->user->can(Article::RULE_UPDATE)) {
    $adminButtons = '<p>'
        . Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) . ' '
        . Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ])
        . '</p>';
}
?>


<?php $this->beginBlock('before_content'); ?>

    <div class="visible-xs-block">
        <!-- admitad.banner: baaa52887bbb01616dab3a3184f61a М.Видео -->
        <a target="_blank" rel="nofollow" href="https://ad.admitad.com/g/baaa52887bbb01616dab3a3184f61a/?i=4">
            <img class="img-responsive" width="468" height="60" border="0" src="https://ad.admitad.com/b/baaa52887bbb01616dab3a3184f61a/" alt="М.Видео"/>
        </a>
        <!-- /admitad.banner -->
    </div>

<?php $this->endBlock(); ?>


<?php $this->beginBlock('sidebar'); ?>
    <!-- admitad.banner: 6928d8b99cbb01616dab3a3184f61a М.Видео -->
    <a target="_blank" rel="nofollow" href="https://ad.admitad.com/g/6928d8b99cbb01616dab3a3184f61a/?i=4">
        <img class="img-responsive" width="160" height="600" border="0" src="https://ad.admitad.com/b/6928d8b99cbb01616dab3a3184f61a/" alt="М.Видео"/>
    </a>
    <!-- /admitad.banner -->

<?php $this->endBlock(); ?>

<?= $adminButtons ?>

<div class="article-view">

    <div class="h1"><?= $this->render('components/_title', ['model' => $model]) ?></div>
    <?= $this->render('components/_published_date', ['model' => $model]) ?>
    &nbsp;&nbsp;&nbsp;

    <?php if($model->pseudo_alias):?>
        <span class="user-sign">
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            <?= $model->pseudo_alias?>
        </span>
    <?php else: ?>
        <a href="<?= $model->createdBy->getUrlView(); ?>">
        <span class="user-sign">
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            <?= $model->createdBy->username ?>
        </span>
        </a>
    <?php endif;?>
    <div class="tags-block"><?= \common\widgets\TagsWidget::widget(['tags' => $model->tags]); ?></div>

    <div class="article-content">
        <?= $model->content ?>
    </div>

    <?= SocialButtonsWidget::widget([
        'url'         => $mainUrl,
        'title'       => $model->title,
        'description' => $model->description,
        'image'       => $model->getUrlFileLogo(true)?: Url::to('/img/social-logo.jpeg', true),
    ]); ?>
    <br/><br/>

    <?= SocialCommentWidget::widget([
        'url' => $mainUrl,
    ]); ?>
</div>
