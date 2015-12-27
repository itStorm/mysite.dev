<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\banner\models\BannerArea */

$this->title = 'Create Banner Area';
$this->params['breadcrumbs'][] = ['label' => 'Banner Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
