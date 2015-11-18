<?php
use yii\helpers\Html;
use yii\bootstrap\Carousel;

/** @var $this yii\web\View */
/** @var $articles app\modules\article\models\Article[] */

?>


<?php
$this->beginBlock('before_content');
echo Carousel::widget([
    'items' => [
        [
            'content' => '<div class="img"><img src="/img/slide-1.jpeg"/></div>',
            'caption' => '<h2></h2><p></p>',
            'options' => []
        ],
        [
            'content' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Index page slide_2_new -->
<ins class="adsbygoogle"
     style="display:inline-block;width:1140px;height:250px"
     data-ad-client="ca-pub-4425366864035089"
     data-ad-slot="3131491655"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>',
            'caption' => '<h2></h2><p></p>',
            'options' => []
        ],
        [
            'content' => '<div class="img"><img src="/img/slide-2.jpeg"></div>',
            'caption' => '<h2></h2><p></p>',
            'options' => []
        ],
        [
            'content' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Index page slide_4_new -->
<ins class="adsbygoogle"
     style="display:inline-block;width:1140px;height:250px"
     data-ad-client="ca-pub-4425366864035089"
     data-ad-slot="4189422458"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>',
            'caption' => '<h2></h2><p></p>',
            'options' => []
        ],
    ],
]);
$this->endBlock();
?>

<?php
$this->beginBlock('sidebar');
echo $this->render('@modules/article/views/default/components/_menu');
$this->endBlock()
?>

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