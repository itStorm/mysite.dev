<?php
namespace common\widgets;

use app\modules\article\models\Tag;
use yii\base\Widget;
use yii\bootstrap\Html;

/**
 * Class TagsInputWidget
 * @package common\widgets
 * @property Tag[] $tags
 */
class TagsWidget extends Widget
{
    public function run()
    {
        $html = '';
        foreach ($this->tags as $tag) {
            $html .= $this->renderTagItem($tag);
        }

        return $html;
    }

    /**
     * @param Tag|Tag[] $tags
     */
    public function setTags($tags)
    {
        $this->tags = is_array($tags) ? $tags : [$tags];
    }

    /**
     * @param Tag $tag
     * @return string
     */
    private function renderTagItem(Tag $tag)
    {
        return Html::a($tag->name, $tag->getUrlView(), ['class' => 'label label-info']);
    }
}