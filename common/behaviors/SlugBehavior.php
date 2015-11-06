<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\base\ModelEvent;

/**
 * Class SlugBehavior
 * @package common\behaviors
 */
class SlugBehavior extends Behavior
{
    /** @var string Название поля для сохранения slug */
    public $slug = 'slug';
    /** @var string Название поля из которого брать слаг */
    public $title = 'title';

    /** @var string */
    public $language;

    /** @var array Соответствие языков */
    public static $langToIcuMapping = [
        'ru-RU' => 'Russian-Latin/BGN',
    ];

    /** @inheritdoc */
    public function __construct($config = [])
    {
        $this->language = \Yii::$app->language;
        parent::__construct($config);
    }

    /** @inheritdoc */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'refreshSlug',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'refreshSlug',
        ];
    }

    /**
     * @param ModelEvent $event
     */
    public function refreshSlug(ModelEvent $event)
    {
        $this->setSlug($this->owner->{$this->title});
    }

    /**
     * Установить слаг
     * @param string $text
     */
    public function setSlug($text)
    {
        $transliteratedText = '';
        if ($langId = $this->getTransliteratorLang()) {
            if ($transliterator = \Transliterator::create($langId)) {
                $transliteratedText = $transliterator->transliterate($text);
            }
        }

        $transliteratedText = !$transliteratedText || is_numeric($transliteratedText) ?
            '' : preg_replace(['/[\s]/i', '/[^\w-]/i'], ['_', ''], $transliteratedText);

        $this->owner->{$this->slug} = $transliteratedText;
    }

    /**
     * @return string|null
     */
    private function getTransliteratorLang()
    {
        return isset(static::$langToIcuMapping[$this->language]) ?
            static::$langToIcuMapping[$this->language] : null;
    }
}