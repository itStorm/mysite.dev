<?php

namespace app\modules\article\models;

use common\behaviors\BlameableBehavior;
use common\libs\safedata\SafeDataFinder;
use Yii;
use yii\db\ActiveQuery;
use \yii\db\ActiveRecord;
use app\modules\user\models\User;
use common\behaviors\TextCutterBehavior;
use yii\helpers\Url;
use common\libs\safedata\interfaces\SafeDataInterface;


/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $created
 * @property string $updated
 * @property integer $created_by
 * @property integer $updated_by
 * @property bool $is_deleted
 * @property bool $is_enabled
 * @property User $createdBy
 * @property User $updatedBy
 * @property Tag[] $tags
 *
 * @see common\behaviors\TextCutter::cut()
 * @method string cut() cut(string $field_name, int $length)
 */
class Article extends ActiveRecord implements SafeDataInterface
{
    const RULE_VIEW = 'article_view';
    const RULE_CREATE = 'article_create';
    const RULE_UPDATE = 'article_update';
    const RULE_UPLOAD_FILES = 'article_upload_files';


    public function behaviors()
    {
        return [
            'textCutter' => [
                'class'  => TextCutterBehavior::className(),
                'fields' => [
                    'content' => 100,
                ]
            ],
            'blameable'  => BlameableBehavior::className(),
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
            [['title', 'content', 'created_by', 'updated_by', 'created', 'updated'], 'required'],

            [['title'], 'string', 'max' => 255],

            ['content', 'string'],

            [['created_by', 'updated_by', 'created', 'updated'], 'integer'],

            [['is_deleted', 'is_enabled'], 'boolean'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    /**
     * @param int $length
     * @return string
     */
    public function getShortContent($length = null)
    {
        return $this->cut('content', $length);
    }

    /**
     * Получить Url к статье
     * @return string
     */
    public function getUrlView()
    {
        return Url::to(['/article/default/view', 'id' => $this->id]);
    }

    /** @inheritdoc */
    public static function hasAccessToDisabled($user)
    {
        return $user->can(self::RULE_UPDATE);
    }

    /** @inheritdoc */
    public static function hasAccessToDeleted($user)
    {
        return $user->can(User::ROLE_NAME_ADMIN);
    }

    /**
     * Пометить удаленным
     * @return bool
     */
    public function markDeleted()
    {
        $this->is_deleted = SafeDataFinder::IS_DELETED;

        return $this->save(false, ['is_deleted']);
    }

    /**
     * Сохранить/установить теги
     * @param array|string $tags
     */
    public function saveTags($tags = [])
    {
        // фильтруем пустые теги
        $tags = is_array($tags) ? $tags : [$tags];
        $tags = array_filter($tags);

        $saveTagsTransaction = Article::getDb()->beginTransaction();
        try {
            // отсоединяем старые теги
            $this->unlinkAllTags();

            // сохраняем заново все теги
            foreach ($tags as $tagName) {
                $tagName = trim($tagName);
                /** @var Tag $tag */
                $tag = Tag::findOne(['name' => $tagName]);
                if (!$tag) {
                    $tag = new Tag();
                    $tag->name = $tagName;
                    $tag->save();
                }
                $this->link('tags', $tag);
            }

            $saveTagsTransaction->commit();
        } catch (\Exception $e) {
            $saveTagsTransaction->rollBack();
        }
    }

    /**
     * Отсоединить все теги
     */
    protected function unlinkAllTags()
    {
        /** @var Tag $tag */
        foreach ($this->tags as $tag) {
            $this->unlink('tags', $tag, true);
        }
    }
}
