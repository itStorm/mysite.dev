<?php
namespace common\widgets;

use yii\base\Widget;

class SocialButtons extends Widget
{
    public function run()
    {
        $js = <<<JS
    VK.init({apiId: 5103140, onlyWidgets: true});
    VK.Widgets.Like("vk_like", {type: "mini", height: 20});

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
JS;
        $view = $this->getView();
        $view->registerJsFile('//vk.com/js/api/openapi.js?117');
        $view->registerJs($js);

        $css = <<<CSS
.social-buttons-item {
    float: left;
}
CSS;
        $view->registerCss($css);

        $html = <<<HTML
    <div class="social-buttons">
        <div class="social-buttons-item" id="vk_like"></div>
        <div class="social-buttons-item fb-like"  data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
    </div>
HTML;

        return $html;
    }
}