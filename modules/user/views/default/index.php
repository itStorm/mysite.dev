<?php
    use app\modules\user\models\User;
    /** @var $model User */
?>

<div class="user-default-index">
    <h1><?= Yii::t('app', 'Profile'); ?></h1>
    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <td><?= $model->id; ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?= $model->username; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= $model->email; ?></td>
        </tr>
    </table>
</div>
