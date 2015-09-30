<?php

namespace app\modules\article\models;

use Yii;
use app\modules\user\models\User;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $created
 * @property string $updated
 * @property integer $user_id
 * @property User $user
 */
class Article extends \yii\db\ActiveRecord
{
    const RULE_VIEW = 'article_view';
    const RULE_CREATE = 'article_create';
    const RULE_UPDATE = 'article_update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'user_id', 'created', 'updated'], 'required'],
            [['title'], 'string', 'max' => 255],
            ['content', 'string'],
            [['user_id','created', 'updated'], 'integer'],
        ];
    }

    /**
     * @return null|User
     */
    public function getUser()
    {
        return User::findIdentity($this->user_id);
    }
}
