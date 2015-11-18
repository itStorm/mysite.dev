<?php
use app\modules\user\models\User;

/** @var $model User */
?>

<div class="user-default-index">
    <h1><?= Yii::t('app', 'Profile'); ?></h1>
    <table class="table table-bordered">
        <tr>
            <th><?= Yii::t('app', 'Username'); ?></th>
            <td><?= $model->username; ?></td>
        </tr>
    </table>
</div>
