<?php

use yii\helpers\Html;
use app\modules\article\models\ArticleEditForm;

/* @var $this yii\web\View */
/* @var $model ArticleEditForm */

$this->title = 'Update Article: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => $model->getModel()->getUrlView()];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/_form', [
        'model' => $model,
    ]) ?>

</div>
