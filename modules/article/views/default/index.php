<?php

use yii\helpers\Html;
use app\modules\article\models\Article;
use yii\widgets\LinkPager;
use yii\data\Pagination;

/** @var $this yii\web\View */
/** @var $articles Article[] */
/** @var $pages Pagination */
/** @var string $title */
/** @var string $title */
/** @var int $countArticles */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
$tagsMenu = $this->render('components/_menu');
?>

<?php $this->beginBlock('before_content'); ?>


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

        <?= $tagsMenu ?>
    </div>
<?php $this->endBlock(); ?>


<?php $this->beginBlock('sidebar'); ?>
    <?= $tagsMenu ?>

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

<div class="article-index">

    <div class="h1"><?= Html::encode($this->title) ?></div>
    <?php if (Yii::$app->user->can(Article::RULE_CREATE)): ?>
        <p>
            <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <div class="list-page">

        <?php
        foreach ($articles as $article): // перебираем статьи
        $articleUrl = $article->getUrlView();
        ?>

            <div class="list-page-item article-announcement">
                <div class="row">
                    <div class="col-sm-4">
                        <a class="open-list-item" href="<?= $articleUrl ?>">
                            <img src="<?= $article->getUrlLogoImageFile(true) ?>">
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <a class="open-list-item" href="<?= $articleUrl ?>">
                            <div class="h3 title"><?= $this->render('components/_title', ['model' => $article]) ?></div>
                            <div><?= $this->render('components/_published_date', ['model' => $article]) ?></div>
                        </a>
                            <div class="tags-block"><?= \common\widgets\TagsWidget::widget(['tags' => $article->tags]); ?></div>
                        <a class="open-list-item" href="<?= $articleUrl ?>">
                            <span class="preview">
                                <span class="fade-out"></span>
                                <?= $article->getShortContent(200); ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
<?php
/*
            ?>
            <div class="list-page-item article-announcement">
                <a class="open-list-item" href="<?= $articleUrl ?>">
                    <div class="h3 title"><?= $this->render('components/_title', ['model' => $article]) ?></div>
                </a>

                <div><?= $this->render('components/_published_date', ['model' => $article]) ?></div>
                <div class="tags-block"><?= \common\widgets\TagsWidget::widget(['tags' => $article->tags]); ?></div>
                <a class="open-list-item" href="<?= $articleUrl ?>">
                    <span class="preview">
                        <span class="fade-out"></span>
                        <?= $article->getShortContent(200); ?>
                    </span>
                    &nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="false"></span>
                </a>
            </div>
*/
?>


        <?php endforeach; ?>

        <?php if (!$articles): ?>
            <div class="alert alert-info" role="alert">
                <?= Yii::t('app', 'Nothing here yet, but it will be interesting here soon.'); ?>
            </div>
        <?php endif; ?>

    </div>

    <?= LinkPager::widget(['pagination' => $pages]); ?>

</div>