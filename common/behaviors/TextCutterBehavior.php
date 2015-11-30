<?php

namespace common\behaviors;

use yii\base\Behavior;
use app\modules\article\models\Article;
use yii\helpers\HtmlPurifier;

/**
 * Class TextCutterBehavior
 * @package common\behaviors
 */
class TextCutterBehavior extends Behavior
{
    public $fields = [];

    /** @var  Article */
    public $owner;


    /**
     * Аккуратная обрезка текста согласно необходимой длинне
     *
     * @param string $propertyName
     * @param int $length
     * @return string
     */
    public function cut($propertyName, $length = null)
    {
        $length = $length ?: $this->fields[$propertyName] ?: null;
        if (!$length) {
            return '';
        }
        $value = empty($this->owner->{$propertyName}) ? '' : $this->owner->{$propertyName};
        $clearValue = HtmlPurifier::process($value, ['HTML.Allowed' => '']);

        // если строка короткая - отдаем её как есть
        if ($length >= strlen($clearValue)) {
            return $clearValue;
        }

        $strPart1 = mb_substr($clearValue, 0, $length, 'UTF-8');
        $strPart2 = mb_substr($clearValue, $length, null, 'UTF-8');

        // если есть пробел после - отрезаем до него
        if ($spacePosition = strpos($strPart2, ' ')) {
            return trim($strPart1 . mb_substr($strPart2, 0, $spacePosition, 'UTF-8'));
        } elseif ($spacePosition = strrpos($strPart1, ' ')) {
            return trim(mb_substr($strPart1, 0, $spacePosition));
        }

        return trim($strPart1);
    }
}