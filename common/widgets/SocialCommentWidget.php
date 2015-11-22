<?php
namespace common\widgets;

use yii\base\Widget;
use yii\bootstrap\Tabs;
use yii\web\View;

/**
 * Class SocialCommentWidget
 * @package common\widgets
 */
class SocialCommentWidget extends Widget
{
    /** @var string */
    public $url = null;

    /** @var string */
    public $urlHash = null;

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        $this->urlHash = md5($this->url);
    }

    /** @inheritdoc */
    public function run()
    {
        $this->registerJs();

        $tabs = new Tabs();
        $tabs->setView($this->getView());
        $html = $tabs->widget([
            'items' => [
                [
                    'label'   => 'Vkontakte',
                    'content' => '<div id="vk_comments"></div>',
                    'active'  => true
                ],
                [
                    'label'   => 'Facebook',
                    'content' => '<div class="fb-comments" data-href="' . $this->url . '" data-width="auto" data-numposts="10"></div>',
                ],
            ],
        ]);

        return $html;
    }

    /**
     * @return $this
     */
    protected function registerJs()
    {
        $this->getView()->registerJsFile('//vk.com/js/api/openapi.js?117');
        $this->getView()->registerJsFile('/js/social.js');

        // Подключение непосредственно к comment-блоку
        $js = <<<JS
    VK.Widgets.Comments("vk_comments", {limit: 10, width: "auto", attach: "photo,video,audio"}, "{$this->urlHash}");
JS;
        $this->getView()->registerJs($js);

        return $this;
    }
}