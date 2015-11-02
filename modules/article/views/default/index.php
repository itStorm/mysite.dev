<?php

use yii\helpers\Html;
use app\modules\article\models\Article;
use yii\widgets\LinkPager;
use yii\data\Pagination;

/** @var $this yii\web\View */
/** @var $articles Article[] */
/** @var $pages Pagination */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
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
            <a href="<?= $article->getUrlView() ?>" class="list-page-item article-announcement">
                <div class="h3"><?= $this->render('components/_title', ['model' => $article]) ?></div>
                <div><?= $this->render('components/_published_date', ['model' => $article]) ?></div>
                <span class="preview">
                    <span class="fade-out"></span>
                    <?= $article->getShortContent(200); ?>
                </span>
                &nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="false"></span>
            </a>
        <?php endforeach; ?>
        <?php if (!$articles): ?>
            <div class="alert alert-info" role="alert">
                <?= Yii::t('app', 'Nothing here yet, but it will be interesting here soon.'); ?>
            </div>
        <?php endif; ?>
    </div>

    <?= LinkPager::widget(['pagination' => $pages]); ?>

</div>
