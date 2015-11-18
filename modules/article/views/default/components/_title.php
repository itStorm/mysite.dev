<?php

use app\modules\article\models\Article;
use yii\helpers\Html;

/* @var $model Article */

?>
<?= Html::encode($model->title); ?>
<?= $model->is_deleted ? ' <span class="glyphicon glyphicon-trash even-less-50"></span>' : '' ?>
<?php
if (Yii::$app->user->can(Article::RULE_UPDATE)) {
    echo $model->is_enabled ? ' <span class="glyphicon glyphicon-eye-open even-less-50"></span>' : ' <span class="glyphicon glyphicon-eye-close  even-less-50"></span>';
}
?>
