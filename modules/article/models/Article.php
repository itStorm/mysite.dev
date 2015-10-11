<?php

namespace app\modules\article\models;

use Yii;
use \yii\db\ActiveRecord;
use app\modules\user\models\User;
use common\behaviors\TextCutter;
use yii\helpers\Url;


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
 *
 * @see common\behaviors\TextCutter::cut()
 * @method string cut() cut(string $field_name, int $length)
 */
class Article extends ActiveRecord
{
    const RULE_VIEW = 'article_view';
    const RULE_CREATE = 'article_create';
    const RULE_UPDATE = 'article_update';


    public function behaviors()
    {
        return [
            'textCutter' => [
                'class'  => TextCutter::className(),
                'fields' => [
                    'content' => 100,
                ]
            ]
        ];
    }

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
            [['user_id', 'created', 'updated'], 'integer'],
        ];
    }

    /**
     * @return null|User
     */
    public function getUser()
    {
        return User::findIdentity($this->user_id);
    }

    /**
     * @param int $length
     * @return string
     */
    public function getShortContent($length = null)
    {
        return $this->cut('content', $length);
    }

    public function getUrl() {
        return Url::to(['/article/default/view', 'id' => $this->id]);
    }
}
