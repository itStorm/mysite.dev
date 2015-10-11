<?php

use yii\helpers\Html;
use app\modules\article\models\Article;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$adminButtons = '';
if (Yii::$app->user->can(Article::RULE_UPDATE)) {
    $adminButtons = '<p>'
        . Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) .' '
        . Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ])
        . '</p>';
}
?>

<?= $adminButtons ?>
<div class="article-view">

    <div class="h1"><?= Html::encode($this->title) ?></div>
    <span class="article-date">
        Published:
        <?= \Yii::$app->formatter->asDatetime($model->created);?>
    </span>
    &nbsp;&nbsp;&nbsp;
    <a href="#">
        <span class="user-sign">
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            <?= $model->user->username ?>
        </span>
    </a>
    <div class="article-content">
        <?= $model->content?>
    </div>
</div>
