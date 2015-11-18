<?php
namespace app\modules\rbac;

use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use app\modules\user\models\User;

class UserRoleRule extends Rule
{
    public $name = 'userRole';

    /** @inheritdoc */
    public function execute($user, $item, $params)
    {
        //Получаем массив пользователя из базы
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {
            $role = $user->role; //Значение из поля role базы данных
            if ($item->name === User::ROLE_NAME_ADMIN) {
                return $role == User::ROLE_ADMIN;
            } elseif ($item->name === User::ROLE_NAME_MODERATOR) {
                //moder является потомком admin, который получает его права
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODERATOR;
            } elseif ($item->name === User::ROLE_NAME_USER) {
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODERATOR
                || $role == User::ROLE_USER;
            }
        }

        return false;
    }
}