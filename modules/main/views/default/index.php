<?php
use yii\helpers\Html;
use yii\bootstrap\Carousel;

/** @var $this common\View */
/** @var $articles app\modules\article\models\Article[] */

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
        <!-- admitad.banner: 52u6hw0nbmbb01616dab8b0fa31d56 Aviasales.ru -->
        <a target="_blank" rel="nofollow" href="https://ad.admitad.com/g/52u6hw0nbmbb01616dab8b0fa31d56/?i=4">
            <img class="img-responsive" border="0" src="https://ad.admitad.com/b/52u6hw0nbmbb01616dab8b0fa31d56/" alt="Aviasales.ru"/>
        </a>
        <!-- /admitad.banner -->
        <?= $tagsMenu ?>
    </div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('sidebar'); ?>
<?= $tagsMenu ?>
<!-- admitad.banner: 6e3e68f66abb01616dab8b0fa31d56 Aviasales.ru -->
<a target="_blank" rel="nofollow" href="https://ad.admitad.com/g/6e3e68f66abb01616dab8b0fa31d56/?i=4">
    <img class="img-responsive" width="120" height="240" border="0" src="https://ad.admitad.com/b/6e3e68f66abb01616dab8b0fa31d56/" alt="Aviasales.ru"/>
</a>
<!-- /admitad.banner -->
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
                    <div class="article-announcement">
                        <div class="h2 title"><?= $article->title; ?></div>
                        <span class="preview">
                            <span class="fade-out"></span>
                            <?= $article->getShortContent(); ?>
                        </span>

                        <p><?= Html::a(Yii::t('app', 'more') . '... &raquo;', $article->getUrlView(), ['class' => 'btn btn-default']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>