<?php
use yii\helpers\Html;
use yii\bootstrap\Carousel;

/** @var $this yii\web\View */
/** @var $articles app\modules\article\models\Article[] */

$tagsMenu = $this->render('@modules/article/views/default/components/_menu');
?>

<?php $this->beginBlock('before_content'); ?>
    <div class="hidden-xs hidden-sm">
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
        <!-- Adapted banner 2015-11-18 -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-4425366864035089"
             data-ad-slot="2690839656"
             data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <?= $tagsMenu ?>
    </div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('sidebar'); ?>
    <div class="hidden-xs">
        <?= $tagsMenu ?>
    </div>
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