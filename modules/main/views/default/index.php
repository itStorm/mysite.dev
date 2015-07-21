<?php
use yii\bootstrap\Carousel;

/* @var $this yii\web\View */
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

    <div class="row">
        <div class="col-sm-4">
            <h2>Header 1</h2>
            <p>Text 1</p>
            <p><a class="btn btn-default" href="#">more... &raquo;</a></p>
        </div>
        <div class="col-sm-4">
            <h2>Header 2</h2>
            <p>Text 2</p>
            <p><a class="btn btn-default" href="#">more... &raquo;</a></p>
        </div>
        <div class="col-sm-4">
            <h2>Header 3</h2>
            <p>Text 3</p>
            <p><a class="btn btn-default" href="#">more... &raquo;</a></p>
        </div>
    </div>

</div>