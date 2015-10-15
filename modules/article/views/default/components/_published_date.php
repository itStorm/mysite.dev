<?php

use app\modules\article\models\Article;
use yii\helpers\Html;

/* @var $model Article */
?>
<span class="article-date">
    <?= Yii::t('app', 'Published: {0}', \Yii::$app->formatter->asDatetime($model->created)) ?>
</span>
