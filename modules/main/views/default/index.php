<?php
use yii\bootstrap\Carousel;

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

        <script type='text/javascript'>(function() {
                /* Optional settings (these lines can be removed): */
                subID = "";  // - local banner key;
                injectTo = "";  // - #id of html element (ex., "top-banner").
                /* End settings block */

                if(injectTo=="")injectTo="admitad_shuffle"+subID+Math.round(Math.random()*100000000);
                if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
                document.write('<div id="'+injectTo+'"></div>');
                var s = document.createElement('script');
                s.type = 'text/javascript'; s.async = true;
                s.src = 'https://ad.admitad.com/shuffle/aa712d5723/'+subid_block+'?inject_to='+injectTo;
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            })();</script>

        <?= $tagsMenu ?>
    </div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('sidebar'); ?>
<?= $tagsMenu ?>

<script type='text/javascript'>(function() {
        /* Optional settings (these lines can be removed): */
        subID = "";  // - local banner key;
        injectTo = "";  // - #id of html element (ex., "top-banner").
        /* End settings block */

        if(injectTo=="")injectTo="admitad_shuffle"+subID+Math.round(Math.random()*100000000);
        if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
        document.write('<div id="'+injectTo+'"></div>');
        var s = document.createElement('script');
        s.type = 'text/javascript'; s.async = true;
        s.src = 'https://ad.admitad.com/shuffle/7e47627c4a/'+subid_block+'?inject_to='+injectTo;
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    })();</script>

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