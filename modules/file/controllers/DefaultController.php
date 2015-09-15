<?php

namespace app\modules\file\controllers;

use Yii;
use yii\web\Controller;
use app\modules\file\lib\elFinder;
use app\modules\file\lib\elFinderConnector;


/**
 * Class DefaultController
 * Загрузка файлов
 * @package app\modules\file\controllers
 */
class DefaultController extends Controller
{
    /** @inheritdoc */
    public function beforeAction($action)
    {
        if ($action->id == 'connector') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->getView()->render('index', [], $this);
    }

    public function actionConnector()
    {
        $this->enableCsrfValidation;
        $opts = [
            'roots' => [
                [
                    'driver' => 'LocalFileSystem',
                    'path'   => Yii::getAlias('@files') . '/',
                    'URL'    => Yii::$app->getRequest()->getHostInfo() . '/files/',
                ]
            ]
        ];

        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();

        exit();
    }
}
