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
    <!-- Adapted banner 2015-11-18 -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-4425366864035089"
         data-ad-slot="2690839656"
         data-ad-format="auto"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <div class="visible-xs-block">
        <?= $tagsMenu ?>
    </div>
<?php $this->endBlock(); ?>


<?php $this->beginBlock('sidebar'); ?>
    <div class="hidden-xs">
        <?= $tagsMenu ?>
    </div>
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
            <?php
            if ($i === $mobileBannerPosition): // если можно - втыкаем баннер
            ?>
                <div class="visible-xs-block">
                    <!-- Mobile horizontal banner 2015-11-21 -->
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:320px;height:50px"
                         data-ad-client="ca-pub-4425366864035089"
                         data-ad-slot="5633972851"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
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
