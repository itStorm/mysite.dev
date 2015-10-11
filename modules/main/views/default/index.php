<?php
use yii\helpers\Html;
use yii\bootstrap\Carousel;
use yii\helpers\HtmlPurifier;

/** @var $this yii\web\View */
/** @var $articles app\modules\article\models\Article[]*/

$this->title = 'Main';
?>


<?php
$this->beginBlock('before_content');
echo Carousel::widget ( [
    'items' => [
        [
            'content' => '<div class="img"><img src="/img/slide-1.jpeg"/></div>',
            'caption' => '<h2></h2><p></p>',
            'options' => []
        ],
        [
            'content' => '<div class="img"><img src="/img/slide-2.jpeg"></div>',
            'caption' => '<h2></h2><p></p>',
            'options' => []
        ],
    ],
]);
$this->endBlock();
?>

<?php $this->beginBlock('sidebar') ?>
<!--    MENU-->
<?php $this->endBlock() ?>

<div class="site-index">
    <?php
    $articlesRows = array_chunk($articles, 3);
    foreach ($articlesRows as $row): ?>
        <div class="row">
            <?php
            /** @var  $row app\modules\article\models\Article[] */
            foreach($row as $article): ?>
                <div class="col-sm-4">
                    <div class="article-announcement">
                        <h2 class="title"><?= $article->title; ?></h2>
                        <span class="preview">
                            <div class="fade-out"></div>
                            <?= $article->getShortContent();?>
                        </span>
                        <p><?= Html::a('more... &raquo;', ['/article/default/view', 'id' => $article->id], ['class' => 'btn btn-default'])?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>