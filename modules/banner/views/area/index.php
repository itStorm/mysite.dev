<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\banner\models\BannerArea;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banner Areas';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banners'), 'url' => ['/banner/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-area-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can(BannerArea::RULE_CREATE)): ?>
        <p>
            <?= Html::a('Create Banner Area', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'alias',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
