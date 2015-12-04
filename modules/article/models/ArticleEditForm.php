<?php

namespace app\modules\article\models;

use app\modules\filestorage\models\File;
use common\behaviors\ImageResizeBehavior;
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

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'imageResize' => [
                'class'  => ImageResizeBehavior::className(),
                'images' => [
                    'logo_file' => [
                        'w' => Article::FILE_LOGO_MIN_WIDTH,
                        'h' => Article::FILE_LOGO_MIN_HEIGHT,
                    ],
                ]
            ],
        ];
    }

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

    /** @inheritdoc */
    public function validate()
    {
        $result = parent::validate();
        $isLogoFileGood = true;

        if ($this->logo_file) {
            list($width, $height) = getimagesize($this->logo_file->tempName);
            if ($width < Article::FILE_LOGO_MIN_WIDTH || $height < Article::FILE_LOGO_MIN_HEIGHT) {
                $this->addError('logo_file', sprintf('Bad file. Minimal size width = %d x height = %d', Article::FILE_LOGO_MIN_WIDTH, Article::FILE_LOGO_MIN_HEIGHT));
                $isLogoFileGood = false;
            }
        }

        return $result && $isLogoFileGood;
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
        $oldLogoImageFile = $article->logoImageFile;

        $saveArticleTransaction = Article::getDb()->beginTransaction();
        try {
            $article->save(false);
            $article->saveTags($this->tags);

            // Если есть логотип - то сохраняем
            if ($this->logo_file) {
                if ($file = File::createFromUploaded($this->logo_file, Article::CONTENT_FILE_LOGO_PATH)) {
                    $article->setLogoImageFile($file);
                    $article->save(false);
                } else {
                    throw new \Exception('Can\'t save logo file');
                }
            }

            /*
             * Удаление старого логотипа если прочекано скртытое поле удаления
             * или загружен новый логотип, при условии что есть что удалять
             */
            if (($this->delete_logo_file || $this->logo_file) && $oldLogoImageFile) {
                $oldLogoImageFile->delete();
            }
        } catch (\Exception $e) {
            $saveArticleTransaction->rollBack();

            return false;
        }

        $saveArticleTransaction->commit();
        $this->id = $article->id;

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
