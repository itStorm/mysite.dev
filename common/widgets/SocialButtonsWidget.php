<?php
namespace common\widgets;

use yii\base\Widget;
use yii\web\View;

class SocialButtonsWidget extends Widget
{
    public $url = null;
    public $type = 'website';
    public $title = null;
    public $description = null;
    public $image = null;

    /** @inheritdoc */
    public function run()
    {
        $this->registerJs()
            ->registerMetaTags()
            ->registerCss();

        $html = <<<HTML
    <div class="social-buttons">
        <div class="social-buttons-item" id="vk_like"></div>
        <div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
    </div>
HTML;

        return $html;
    }

    /**
     * @return $this
     */
    protected function registerJs()
    {
        $this->getView()->registerJsFile('//vk.com/js/api/openapi.js?117');
        $this->getView()->registerJsFile('/js/social.js');

        // Подключение непосредственно к like-блоку
        $js = <<<JS
    VK.Widgets.Like("vk_like", {type: "button", height: 20});
JS;
        $this->getView()->registerJs($js);

        return $this;
    }

    /**
     * @return $this
     */
    protected function registerMetaTags()
    {
        $tagsData = array_combine(
            [
                'url',
                'type',
                'title',
                'description',
                'image',
            ],
            [
                $this->url,
                $this->type,
                $this->title,
                $this->description,
                $this->image,
            ]);
        $tagsData = array_filter($tagsData);

        foreach ($tagsData as $property => $value) {
            $this->getView()->registerMetaTag([
                'property' => 'og:' . $property,
                'content'  => $value
            ]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function registerCss()
    {
        $css = <<<CSS
.social-buttons-item {
    float: left;
}
CSS;
        $this->getView()->registerCss($css);

        return $this;
    }
}