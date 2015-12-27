<?php
use yii\bootstrap\Carousel;
use app\modules\banner\models\BannerArea;

/** @var $this common\View */
/** @var $articles app\modules\article\models\Article[] */

$this->title = 'Интернет-журнал RACOCAT, публикации, статьи, лайфхаки';
$this->addKeywords('журнал, интернет-журнал, газета, независимый журнал, новости, публикации, статьи, события, отзывы, лайфхаки');
$this->setDescription('Интернет-журнал RACOCAT - интересные публикации, полезные советы, лайфхаки');

$tagsMenu = $this->render('@modules/article/views/default/components/_menu');

$this->registerJsFile('//vk.com/js/api/openapi.js?121');
$this->registerJsFile('/js/social.js');
?>

<?php $this->beginBlock('before_content'); ?>
    <div class="hidden-xs">
        <?= Carousel::widget([
            'items' => [
                [
                    'content' => '<div class="img"><img class="img-responsive" src="/img/slide-3.jpeg"/></div>',
                    'caption' => '<h2>Подписывайтесь в социальных сетях</h2>
                                    <div>
                                        <a class="link-no-decorate" href="https://vk.com/racocat" target="_blank" rel="nofollow">
                                            <img alt="vk" width="100px" height="100px" src="/img/vk.png"/>
                                        </a>
                                        <a class="link-no-decorate" href="https://www.facebook.com/racocat" target="_blank" rel="nofollow">
                                            <img alt="facebook" width="100px" height="100px" src="/img/fb.png"/>
                                        </a>
                                    </div>',
                    'options' => []
                ],
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

<div class="hidden-xs">
    <div class="row">
        <div class="col-sm-6">
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>
            <!-- VK Widget -->
            <div id="vk_groups"></div>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {mode: 0, width: "auto", height: "180", color1: 'FFFFFF', color2: '333', color3: '9D9D9D'}, 107937086);
            </script>
        </div>
        <div class="col-sm-6">
            <div class="fb-page" data-href="https://www.facebook.com/racocat" data-width="auto" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                <div class="fb-xfbml-parse-ignore">
                    <blockquote cite="https://www.facebook.com/facebook">
                        <a href="https://www.facebook.com/facebook">Facebook</a>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>