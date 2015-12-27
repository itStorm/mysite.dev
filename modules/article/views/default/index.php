<?php

use yii\helpers\Html;
use app\modules\article\models\Article;
use yii\widgets\LinkPager;
use yii\data\Pagination;
use app\modules\banner\models\BannerArea;

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
    <?= BannerArea::renderArea('article-index-all-pages-top'); ?>
    <div class="visible-xs-block">
        <?= $tagsMenu ?>
    </div>
<?php $this->endBlock(); ?>


<?php $this->beginBlock('sidebar'); ?>
    <?= $tagsMenu ?>
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
        // позиция для размещения баннера для Pad устройств, в виде индекса, в массиве
        $mobileBannerPosition = $countArticles > 7 ? floor(10 / 2) - 1 : null;

        foreach ($articles as $i => $article): // перебираем статьи
        $articleUrl = $article->getUrlView();
        ?>

            <div class="list-page-item article-list-item">
                <div class="row">
                    <div class="col-sm-4">
                        <a class="open-list-item" href="<?= $articleUrl ?>">
                            <div class="logo-image">
                                <img src="<?= $article->getUrlLogoImageFile(true) ?>">
                                <div class="shadow"></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <div class="article-announcement">
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
            </div>

            <?php
            if ($i === $mobileBannerPosition): // если можно - втыкаем баннер
                ?>
                <div class="visible-xs-block">
                    <?= BannerArea::renderArea('article-index-xs-pages-center'); ?>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>

        <?php if (!$articles): ?>
            <div class="alert alert-info" role="alert">
                <?= Yii::t('app', 'Nothing here yet, but it will be interesting here soon.'); ?>
            </div>
        <?php endif; ?>

    </div>

    <?= LinkPager::widget(['pagination' => $pages]); ?>

</div>

<div class="hidden-xs">
    <?= BannerArea::renderArea('article-index-big-pages-bottom'); ?>
</div>