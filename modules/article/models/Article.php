<?php

namespace app\modules\article\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $created
 * @property string $updated
 * @property integer $user_id
 *
 * @property Users $user
 */
class Article extends \yii\db\ActiveRecord
{
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
            [['content'], 'string'],
            [['created', 'updated'], 'safe'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255]
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
