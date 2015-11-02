<?php

namespace app\modules\article\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_base
 * @property integer $is_main
 * @property string $slug
 * @property Article[] $articles
 */
class Tag extends ActiveRecord
{
    // Основные теги для автокомплита
    const IS_BASE = 1;
    const NOT_BASE = 0;

    // Теги для главных странц, они же рубрики
    const IS_MAIN = 1;
    const NOT_MAIN = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_base'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'name'    => 'Name',
            'is_base' => 'Is Base',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])
            ->viaTable('article_tag', ['tag_id' => 'id']);
    }

    /**
     * Базовые теги (исп. в автокомплите)
     * @return array
     */
    public static function getBaseTagsNames()
    {
        return self::find()
            ->select('name')
            ->where([
                'is_base' => self::IS_BASE,
            ])
            ->asArray()
            ->column();
    }

    /**
     * Получить теги для виджета (главной страницы)
     * @return Tag[]
     */
    public static function getMainTags()
    {
        return self::findAll([
            'is_main' => self::IS_MAIN,
        ]);
    }

    /**
     * Просмотр категории
     * @return string
     */
    public function getUrlView()
    {
        return Url::to(['/article/default/category', 'category' => $this->slug ?: $this->id]);
    }

}