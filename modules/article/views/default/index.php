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
    <div class="visible-xs-block">

        <!-- admitad.banner: po4p9ymmvobb01616dab8b0fa31d56 Aviasales.ru -->
        <a target="_blank" rel="nofollow" href="https://ad.admitad.com/g/po4p9ymmvobb01616dab8b0fa31d56/?i=4">
            <img class="img-responsive" width="468" height="60" border="0" src="https://ad.admitad.com/b/po4p9ymmvobb01616dab8b0fa31d56/" alt="Aviasales.ru"/>
        </a>
        <!-- /admitad.banner -->

        <?= $tagsMenu ?>
    </div>
<?php $this->endBlock(); ?>


<?php $this->beginBlock('sidebar'); ?>
    <?= $tagsMenu ?>

    <!-- admitad.banner: 096c4f4d1bbb01616dab8b0fa31d56 Aviasales.ru -->
    <a target="_blank" rel="nofollow" href="https://ad.admitad.com/g/096c4f4d1bbb01616dab8b0fa31d56/?i=4">
        <img class="img-responsive" width="120" height="600" border="0" src="https://ad.admitad.com/b/096c4f4d1bbb01616dab8b0fa31d56/" alt="Aviasales.ru"/>
    </a>
    <!-- /admitad.banner -->

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
        <?php endforeach; ?>

        <?php if (!$articles): ?>
            <div class="alert alert-info" role="alert">
                <?= Yii::t('app', 'Nothing here yet, but it will be interesting here soon.'); ?>
            </div>
        <?php endif; ?>

    </div>

    <?= LinkPager::widget(['pagination' => $pages]); ?>

</div>

<!-- admitad.banner: 56fbd3206dbb01616dab3a3184f61a М.Видео -->
<a target="_blank" rel="nofollow" href="https://ad.admitad.com/g/56fbd3206dbb01616dab3a3184f61a/?i=4">
    <img class="img-responsive" width="728" height="90" border="0" src="https://ad.admitad.com/b/56fbd3206dbb01616dab3a3184f61a/" alt="М.Видео"/>
</a>
<!-- /admitad.banner -->