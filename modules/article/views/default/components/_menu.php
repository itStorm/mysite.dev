<?php
use yii\helpers\Html;

?>
<div class="sidebar-module">
    <ol class="list-unstyled">
        <li>
            <?= Html::a(
                '<span class="glyphicon glyphicon-list" aria-hidden="true"></span> ' . Yii::t('app', 'All articles'),
                ['/article/default/index']); ?>
        </li>
    </ol>
</div>