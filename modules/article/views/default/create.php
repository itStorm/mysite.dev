<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Article */

$this->title = 'Create Article';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/_form', [
        'model' => $model,
    ]) ?>

</div>
