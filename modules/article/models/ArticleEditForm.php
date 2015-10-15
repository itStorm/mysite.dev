<?php

namespace app\modules\article\models;

use Yii;
use yii\base\Model;

/**
 * Class ArticleEditForm
 * @package app\modules\article\models
 */
class ArticleEditForm extends Model
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
    /** @var  integer */
    public $user_id;
    /** @var bool */
    public $is_deleted;
    /** @var bool */
    public $is_enabled;

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
        ];
    }

    /**
     * @param Article $article
     */
    public function setModel(Article $article) {
        $this->model = $article;
        $this->setAttributes($article->getAttributes(), false);
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
        $article->id = $this->id;
        $article->user_id = Yii::$app->user->id;
        $article->title = $this->title;
        $article->content = $this->content;
        $article->created = $this->created;
        $article->updated = $this->updated;
        $article->is_enabled = $this->is_enabled;
        $article->is_deleted = $this->is_deleted;

        if ($article->save()) {
            $this->id = $article->id;

            return true;
        }

        return false;
    }

    /**
     * @return Article
     */
    private function getModel()
    {
        if (!$this->model) {
            $this->model = new Article();
        }

        return $this->model;
    }
}
