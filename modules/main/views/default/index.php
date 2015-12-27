<?php
use yii\bootstrap\Carousel;
use app\modules\banner\models\BannerArea;

/** @var $this common\View */
/** @var $articles app\modules\article\models\Article[] */

$this->title = 'Интернет-журнал RACOCAT, публикации, статьи, лайфхаки';
$this->addKeywords('журнал, интернет-журнал, газета, независимый журнал, новости, публикации, статьи, события, отзывы, лайфхаки');
$this->setDescription('Интернет-журнал RACOCAT - интересные публикации, полезные советы, лайфхаки');

$tagsMenu = $this->render('@modules/article/views/default/components/_menu');
?>

<?php $this->beginBlock('before_content'); ?>
    <div class="hidden-xs">
        <?= Carousel::widget([
            'items' => [
                [
                    'content' => '<div class="img"><img class="img-responsive" src="/img/slide-1.jpeg"/></div>',
                    'caption' => '<h2></h2><p></p>',
                    'options' => []
                ],
                [
                    'content' => '<div class="img"><img class="img-responsive" src="/img/slide-2.jpeg"></div>',
                    'caption' => '<h2></h2><p></p>',
                    'options' => []
                ],
            ],
        ]) ?>
    </div>
    <div class="visible-xs-block">
        <?= BannerArea::renderArea('main-index-xs-pages-top'); ?>
        <?= $tagsMenu ?>
    </div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('sidebar'); ?>
    <?= $tagsMenu ?>
<?php $this->endBlock(); ?>

<div class="site-index">
    <?php
    $articlesRows = array_chunk($articles, 3);
    foreach ($articlesRows as $row): ?>
        <div class="row">
            <?php
            /** @var  $row app\modules\article\models\Article[] */
            foreach ($row as $article): ?>
                <div class="col-sm-4">
                    <div class="tile-item">
                        <a href="<?= $article->getUrlView()?>">
                            <?php if($logoImageUrl = $article->getUrlLogoImageFile()): ?>
                                <div class="logo-image">
                                    <img src="<?= $logoImageUrl?>">
                                    <div class="shadow"></div>
                                </div>
                            <?php endif; ?>
                            <div class="article-announcement">
                                <div class="h2 title"><?= $article->title; ?></div>
                                <span class="preview">
                                    <span class="fade-out"></span>
                                    <?= $article->getShortContent(); ?>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>