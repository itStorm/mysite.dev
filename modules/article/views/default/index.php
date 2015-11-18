<?php

use yii\helpers\Html;
use app\modules\article\models\Article;
use yii\widgets\LinkPager;
use yii\data\Pagination;

/** @var $this yii\web\View */
/** @var $articles Article[] */
/** @var $pages Pagination */
/** @var string $title */

$this->title = isset($title) ? $title : Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$this->beginBlock('before_content');
echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Article list before_content -->
<ins class="adsbygoogle"
     style="display:inline-block;width:1140px;height:90px"
     data-ad-client="ca-pub-4425366864035089"
     data-ad-slot="8678497659"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';
$this->endBlock();
?>

<?php
$this->beginBlock('sidebar');
echo $this->render('components/_menu');
$this->endBlock();
?>

<div class="article-index">

    <div class="h1"><?= Html::encode($this->title) ?></div>
    <?php if (Yii::$app->user->can(Article::RULE_CREATE)): ?>
        <p>
            <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <div class="list-page">
        <?php foreach ($articles as $article): ?>
            <?php
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
