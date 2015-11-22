<?php
use yii\helpers\Html;
use app\modules\article\models\Tag;
use app\modules\article\controllers\DefaultController as ArticleController;

$tags = Tag::getMainTags();
$currentURLPath = '/' . Yii::$app->getRequest()->getPathInfo();
?>
<div class="sidebar-module">
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-list" aria-hidden="true"></span> ' . Yii::t('app', 'All articles'),
            [ArticleController::URL_PATH_INDEX],
            ['class' => 'btn btn-default']); ?>
    </p>

    <?php foreach ($tags as $tag): ?>
        <?php
        $urlViewTag = $tag->getUrlView();
        $isActiveLink = ($currentURLPath == $urlViewTag);
        $additionalClass = $isActiveLink ? 'btn-info' : '';
        ?>
        <?= Html::a($tag->name, $urlViewTag,
            ['class' => ['tag', 'btn', 'btn-default', $additionalClass]]); ?>
    <?php endforeach; ?>
    <div class="clear"?></div>
</div>