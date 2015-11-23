<?php

namespace app\modules\article\models;

use common\libs\safedata\SafeDataFinder;
use common\widgets\interfaces\TagsInterface;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class ArticleEditForm
 * @package app\modules\article\models
 */
class ArticleEditForm extends Model implements TagsInterface
{

    /** @var  integer */
    public $id;
    /** @var  string */
    public $title;
    /** @var  string */
    public $description;
    /** @var  string */
    public $content;
    /** @var  int */
    public $published_date;
    /** @var bool */
    public $is_deleted = 0;
    /** @var bool */
    public $is_enabled = 0;
    /** @var  string */
    public $pseudo_alias;
    /** @var UploadedFile */
    public $logo_file;
    /** @var  bool */
    public $delete_logo_file = 0;

    /** @var array */
    public $tags;

    /** @var Article */
    private $model;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'filter', 'filter' => 'trim'],
            [['title'], 'string', 'length' => [2, 255]],

            [['pseudo_alias'], 'filter', 'filter' => 'trim'],
            [['pseudo_alias'], 'string', 'length' => [2, 255]],

            [['description'], 'filter', 'filter' => 'trim'],
            [['description'], 'string', 'max' => 512],

            [['content'], 'required'],
            [['content'], 'filter', 'filter' => 'trim'],
            [['content'], 'string'],

            [['published_date'], 'required'],
            [['published_date'], 'date', 'format' => 'php:U'],

            [['is_deleted', 'is_enabled', 'delete_logo_file'], 'boolean'],

            [['logo_file'], 'file', 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'mimeTypes' => ['image/jpeg', 'image/gif', 'image/png'], 'maxSize' => 1024 * 1024],

            [['tags'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title'                          => 'Title',
            'content'                        => 'Content',
            'published_date'                 => 'Published date',
            SafeDataFinder::FIELD_IS_ENABLED => 'Enable',
            SafeDataFinder::FIELD_IS_DELETED => 'Deleted',
            'tags'                           => 'Tags',
            'logo_file'                      => 'Logo file',
        ];
    }

    /**
     * @param Article $article
     */
    public function setModel(Article $article)
    {
        $this->setAttributes($article->getAttributes(), false);
        $this->model = $article;
    }

    /** @inheritdoc */
    public function getTags()
    {
        if (is_null($this->tags)) {
            $this->tags = $this->getModel()->getTags()->select('name')->asArray()->column();
        }

        return $this->tags;
    }

    /** @inheritdoc */
    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);
        $this->logo_file = UploadedFile::getInstance($this, 'logo_file');

        return $result;
    }

    /**
     * Сохранить статью
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $article = $this->getModel();
        $article->setAttributes($this->getAttributes());

        $saveArticleTransaction = Article::getDb()->beginTransaction();
        try {
            $article->save(false);
            $article->saveTags($this->tags);

            $filePath = Yii::getAlias('@files') . DIRECTORY_SEPARATOR . Article::CONTENT_FILE_LOGO_PATH . DIRECTORY_SEPARATOR;

            // Если удаление прочекано
            if ($this->delete_logo_file && $article->logo_filename) {
                $fileName = $article->logo_filename;
                $article->logo_filename = '';
                $article->save(false, ['logo_filename']);
                unlink($filePath . $fileName);
            }

            // Если есть логотип - то пересохраняем
            if ($this->logo_file) {
                $fileName = md5(Article::tableName() . $article->id) . '.' . $this->logo_file->extension;
                $this->logo_file->saveAs($filePath . $fileName);
                $article->logo_filename = $fileName;
                $article->save(false, ['logo_filename']);
            }
            $this->id = $article->id;
        } catch (\Exception $e) {
            $saveArticleTransaction->rollBack();

            return false;
        }

        $saveArticleTransaction->commit();

        return true;
    }

    /**
     * @return Article
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new Article();
        }

        return $this->model;
    }
}
