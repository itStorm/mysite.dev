<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\web\User;

/**
 * Class Blameable
 * @package common\behaviors
 */
class BlameableBehavior extends Behavior
{
    public $createdBy = 'created_by';
    public $updatedBy = 'updated_by';

    /** @inheritdoc */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }


    /**
     * @param ModelEvent $event
     */
    public function beforeInsert(ModelEvent $event)
    {
        $this->setCreatedBy();
        $this->setUpdatedBy();
    }

    /**
     * @param ModelEvent $event
     */
    public function beforeUpdate(ModelEvent $event)
    {
        $this->setUpdatedBy();
    }

    /**
     * @param User|null $user
     */
    public function setCreatedBy(User $user = null)
    {
        $userId = $user ? $user->id : \Yii::$app->getUser()->id;
        $this->owner->{$this->createdBy} = $userId;
    }

    /**
     * @param User|null $user
     */
    public function setUpdatedBy(User $user = null)
    {
        $userId = $user ? $user->id : \Yii::$app->getUser()->id;
        $this->owner->{$this->updatedBy} = $userId;
    }
}