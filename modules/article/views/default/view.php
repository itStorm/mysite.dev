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

        <script type='text/javascript'>(function() {
                /* Optional settings (these lines can be removed): */
                subID = "";  // - local banner key;
                injectTo = "";  // - #id of html element (ex., "top-banner").
                /* End settings block */

                if(injectTo=="")injectTo="admitad_shuffle"+subID+Math.round(Math.random()*100000000);
                if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
                document.write('<div id="'+injectTo+'"></div>');
                var s = document.createElement('script');
                s.type = 'text/javascript'; s.async = true;
                s.src = 'https://ad.admitad.com/shuffle/aa712d5723/'+subid_block+'?inject_to='+injectTo;
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            })();</script>

    </div>

<?php $this->endBlock(); ?>


<?php $this->beginBlock('sidebar'); ?>

<script type='text/javascript'>(function() {
        /* Optional settings (these lines can be removed): */
        subID = "";  // - local banner key;
        injectTo = "";  // - #id of html element (ex., "top-banner").
        /* End settings block */

        if(injectTo=="")injectTo="admitad_shuffle"+subID+Math.round(Math.random()*100000000);
        if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
        document.write('<div id="'+injectTo+'"></div>');
        var s = document.createElement('script');
        s.type = 'text/javascript'; s.async = true;
        s.src = 'https://ad.admitad.com/shuffle/1a643057aa/'+subid_block+'?inject_to='+injectTo;
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    })();</script>

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
        'image'       => $model->getUrlLogoImageFile(true)?: Url::to('/img/social-logo.jpeg', true),
    ]); ?>
    <br/>
    <div class="hidden-xs">

        <script type='text/javascript'>(function() {
                /* Optional settings (these lines can be removed): */
                subID = "";  // - local banner key;
                injectTo = "";  // - #id of html element (ex., "top-banner").
                /* End settings block */

                if(injectTo=="")injectTo="admitad_shuffle"+subID+Math.round(Math.random()*100000000);
                if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
                document.write('<div id="'+injectTo+'"></div>');
                var s = document.createElement('script');
                s.type = 'text/javascript'; s.async = true;
                s.src = 'https://ad.admitad.com/shuffle/42eafc472c/'+subid_block+'?inject_to='+injectTo;
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            })();</script>

    </div>
    <br/>
    <?= SocialCommentWidget::widget([
        'url' => $mainUrl,
    ]); ?>
</div>
