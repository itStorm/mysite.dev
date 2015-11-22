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
        <!-- Adapted banner 2015-11-18 -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-4425366864035089"
             data-ad-slot="2690839656"
             data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
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

    <div class="article-content">
        <?= $model->content ?>
    </div>
    <?= SocialButtonsWidget::widget([
        'url'         => $mainUrl,
        'title'       => $model->title,
        'description' => $model->description,
        'image'       => Url::to('/img/social-logo.jpeg', true),
    ]); ?>
    <br/><br/>
    <div class="hidden-xs">
        <!-- Desktop horizontal banner 2015-11-21 -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-4425366864035089"
             data-ad-slot="6412702055"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <?= SocialCommentWidget::widget([
        'url' => $mainUrl,
    ]); ?>
</div>
