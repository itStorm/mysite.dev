<?php
use yii\helpers\Html;
use yii\bootstrap\Carousel;
use yii\helpers\HtmlPurifier;

/** @var $this yii\web\View */
/** @var $articles app\modules\article\models\Article[]*/

$this->title = 'My Yii Application';
?>


<?php
$this->beginBlock('before_content');
echo Carousel::widget ( [
    'items' => [
        [
            'content' => '<div class="img"><img src="//:0"/></div>',
            'caption' => '<h2>Article caption 1</h2><p>announcement text 1 .......</p>',
            'options' => []
        ],
        [
            'content' => '<div class="img"><img src="//:0"/></div>',
            'caption' => '<h2>Article caption 2</h2><p>announcement text 2 .......</p>',
            'options' => []
        ],
    ],
]);
$this->endBlock();
?>

<?php $this->beginBlock('sidebar') ?>
    MENU
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
                    <h2><?= $article->title; ?></h2>
                    <p><?= HtmlPurifier::process($article->content, ['HTML.Allowed' => '']) ?></p>
                    <p><?= Html::a('more... &raquo;', ['/article/default/view', 'id' => $article->id], ['class' => 'btn btn-default'])?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>