<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\banner\models\Banner;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">

    <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?php if (Yii::$app->user->can(Banner::RULE_CREATE)): ?>
                <?= Html::a('Create Banner', ['create'], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
            <?= Html::a('Banner areas list', ['/banner/area/index'], ['class' => 'btn btn-info']) ?>
        </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'code:ntext',
            'area_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
