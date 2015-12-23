<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\banner\models\BannerArea */

$this->title = 'Update Banner Area: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Banner Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="banner-area-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
