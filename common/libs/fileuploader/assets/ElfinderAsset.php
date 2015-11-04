<?php
namespace common\libs\fileuploader\assets;

use yii\bootstrap\BootstrapAsset;
use yii\jui\JuiAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Class ElfinderAsset
 * @package app\assets
 */
class ElfinderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'elfinder/css/elfinder.min.css',
        'elfinder/css/theme.css',
    ];
    public $js = [
        'elfinder/js/elfinder.min.js',
        'elfinder/js/i18n/elfinder.ru.js',
    ];

    public function init()
    {
        parent::init();

        $this->depends = [
            YiiAsset::className(),
            BootstrapAsset::className(),
            JuiAsset::className(),
        ];
    }
}
