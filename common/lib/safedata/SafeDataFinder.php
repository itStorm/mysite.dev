<?php
namespace common\lib\safedata;

use common\lib\safedata\interfaces\SafeDataInterface;
use Yii;
use yii\base\ErrorException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\User;

class SafeDataFinder
{
    const FIELD_IS_DELETED = 'is_deleted';
    const FIELD_IS_ENABLED = 'is_enabled';

    const IS_DELETED = true;
    const NOT_DELETED = false;

    const IS_ENABLED = true;
    const IS_DISABLED = false;


    /**
     * @var ActiveRecord|SafeDataInterface
     */
    private $activeRecord;

    /**
     * @var User
     */
    private $user;

    /**
     * @param string $className
     * @param User|null $user
     * @throws ErrorException
     */
    public function __construct($className, User $user = null)
    {
        /** @var ActiveRecord $activeRecord */
        $activeRecord = new $className;
        if (!($activeRecord instanceof SafeDataInterface)) {
            throw new ErrorException($className . ' must be instanceof SafeDataInterface');
        }

        $this->activeRecord = $activeRecord;
        $this->user = $user ?: Yii::$app->user;
    }

    /**
     * @param $className
     * @param User|null $user
     * @return SafeDataFinder
     */
    public static function init($className, User $user = null)
    {
        $instance = new self($className, $user);

        return $instance;
    }

    /**
     * @return ActiveQuery
     */
    public function find()
    {
        $activeQuery = $this->activeRecord->find();
        $activeQuery->where($this->getLimitingCondition());

        return $activeQuery;
    }

    /**
     * @param mixed $condition primary key value or a set of column values
     * @return null|ActiveRecord
     * @throws ErrorException
     */
    public function findOne($condition)
    {
        if (!ArrayHelper::isAssociative($condition)) {
            $primaryKey = $this->activeRecord->primaryKey();
            if (!isset($primaryKey[0])) {
                throw new ErrorException($this->activeRecord->className() . ' must have primary key');
            }
            $condition = ['id' => $condition];
        }

        $condition = $this->getLimitingCondition() + $condition;

        return $this->activeRecord->findOne($condition);
    }

    /**
     * @return array
     */
    public function getLimitingCondition()
    {
        $conditions = [];

        if (!$this->activeRecord->hasAccessToDeleted($this->user)) {
            $conditions[self::FIELD_IS_DELETED] = self::NOT_DELETED;
        }
        if (!$this->activeRecord->hasAccessToDisabled($this->user)) {
            $conditions[self::FIELD_IS_ENABLED] = self::IS_ENABLED;
        }

        return $conditions;
    }
}