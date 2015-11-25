<?php
namespace common;

use \yii\web\View as BaseView;

class View extends BaseView
{
    /** @var string */
    public $keywords = [];

    /** @var string */
    public $description = null;

    /**
     * Добавление ключевых слов в метатег
     * @param string $keywords
     */
    public function addKeywords($keywords)
    {
        if (empty($keywords)) {
            return;
        }
        $this->keywords[] = $keywords;
    }

    /**
     * Установить метатег примечания
     * @param $description
     */
    public function setDescription($description)
    {
        if (empty($description)) {
            return;
        }
        $this->description = $description;
    }

    /** @inheritdoc */
    public function renderHeadHtml()
    {
        $this->registerKeywords();
        $this->registerDescription();

        return parent::renderHeadHtml();
    }

    protected function registerKeywords()
    {
        if (!$this->keywords)
            return;
        $this->registerMetaTag([
            'property' => 'keywords',
            'content'  => implode(', ', $this->keywords),
        ]);
    }

    protected function registerDescription()
    {
        if (!$this->description)
            return;
        $this->registerMetaTag([
            'property' => 'keywords',
            'content'  => $this->description,
        ]);
    }

}