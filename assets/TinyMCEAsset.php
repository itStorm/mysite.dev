<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class TinyMCEAsset
 * @package app\assets
 */
class TinyMCEAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'js/tinymce/tinymce.min.js',
        'js/wisywyg.js',
    ];

    public function init()
    {
        parent::init();

        $this->depends = [
            AppAsset::className(),
        ];
    }
}
