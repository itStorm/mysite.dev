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
            [['title'], 'required'],
            [['title'], 'filter', 'filter' => 'trim'],
            [['title'], 'string', 'length' => [2, 255]],

            [['content'], 'required'],
            [['content'], 'filter', 'filter' => 'trim'],
            [['content'], 'string'],

            [['created', 'updated'], 'required'],
            [['created', 'updated'], 'date', 'format' => 'yyyy-MM-dd'],

            [['user_id'], 'required'],
            [['user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'created' => 'Created',
            'updated' => 'Updated',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return User::findIdentity($this->user_id);
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        $created = new \DateTime($this->created);

        return $created->format('j F, Y');
    }
}
