<?php
namespace common\libs\fileuploader\actions;

use common\libs\fileuploader\elfinder\elFinder;
use common\libs\fileuploader\elfinder\elFinderConnector;
use yii\base\Action;
use \Yii;

/**
 * Class FileConnectorAction
 * @package common\actions
 */
class FileConnectorAction extends Action
{
    private $basePath;

    public $path = '';

    public function init()
    {
        parent::init();

        $this->basePath = Yii::getAlias('@files') . DIRECTORY_SEPARATOR;
    }

    public function run()
    {
        $this->controller->enableCsrfValidation = false;

        $opts = [
            'roots' => [
                [
                    'driver' => 'LocalFileSystem',
                    'path'   => $this->basePath . $this->path . DIRECTORY_SEPARATOR,
                    'URL'    => Yii::$app->getRequest()->getHostInfo() . '/files/' . $this->path . '/',
                ]
            ]
        ];
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();

        exit();
    }
}