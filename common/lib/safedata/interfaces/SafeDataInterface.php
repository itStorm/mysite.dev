<?php
namespace common\lib\safedata\interfaces;

use yii\web\User;


interface SafeDataInterface
{
    /**
     * @param User $user
     * @return bool
     */
    public static function hasAccessToDisabled($user);

    /**
     * @param User $user
     * @return bool
     */
    public static function hasAccessToDeleted($user);
}