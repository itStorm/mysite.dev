<?php

use app\modules\article\models\Article;
use yii\helpers\Html;

/* @var $model Article */

?>
<?= Html::encode($model->title); ?>
<?= $model->is_deleted ? ' <span class="glyphicon glyphicon-trash"></span>' : '' ?>
<?php
if (Yii::$app->user->can(Article::RULE_UPDATE)) {
    echo $model->is_enabled ? ' <span class="glyphicon glyphicon-eye-open"></span>' : ' <span class="glyphicon glyphicon-eye-close"></span>';
}
?>
