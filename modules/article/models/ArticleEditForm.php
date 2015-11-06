<?php

namespace app\modules\article\models;

use common\widgets\interfaces\TagsInterface;
use Yii;
use yii\base\Model;

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
    public $content;
    /** @var  string */
    public $created;
    /** @var  string */
    public $updated;
    /** @var bool */
    public $is_deleted = 0;
    /** @var bool */
    public $is_enabled = 0;

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

            [['content'], 'required'],
            [['content'], 'filter', 'filter' => 'trim'],
            [['content'], 'string'],

            [['created', 'updated'], 'required'],
            [['created', 'updated'], 'date', 'format' => 'php:U'],

            [['is_deleted', 'is_enabled'], 'boolean'],

            [['tags'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title'      => 'Title',
            'content'    => 'Content',
            'created'    => 'Created',
            'updated'    => 'Updated',
            'is_enabled' => 'Enable',
            'is_deleted' => 'Deleted',
            'tags'       => 'Tags',
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

        if ($article->save(false)) {
            $article->saveTags($this->tags);
            $this->id = $article->id;

            return true;
        }

        return false;
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
