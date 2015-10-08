<?php

namespace common\behaviors;

use yii\base\Behavior;
use app\modules\article\models\Article;
use yii\helpers\HtmlPurifier;

class TextCutter extends Behavior
{
    public $fields = [];

    /** @var  Article */
    public $owner;


    /**
     * @param string $propertyName
     * @return string
     */
    public function cut($propertyName)
    {
        $length = $this->fields[$propertyName];

        if (!$length) {
            return '';
        }
        $value = $this->owner[$propertyName] ?: '';
        $clearValue = HtmlPurifier::process($value, ['HTML.Allowed' => '']);

        // если строка короткая - отдаем её как есть
        if ($length >= strlen($clearValue)) {
            return $clearValue;
        }

        $strPart1 = mb_substr($clearValue, 0, $length);
        $strPart2 = mb_substr($clearValue, $length - 1);

        // если есть пробел после - отрезаем до него
        if ($spacePosition = strpos($strPart2, ' ')) {
            return trim($strPart1 . mb_substr($strPart2, 0, $spacePosition));
        } elseif ($spacePosition = strrpos($strPart1, ' ')) {
            return trim(mb_substr($strPart1, 0, $spacePosition));
        }

        return trim($strPart1);
    }
}