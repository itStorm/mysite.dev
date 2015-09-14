<?php

namespace app\modules\file\controllers;

use yii\web\Controller;

/**
 * Class DefaultController
 * Загрузка файлов
 * @package app\modules\file\controllers
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->getView()->render('index', [], $this);
    }

    public function actionConnector()
    {
        var_dump('connector');
        die();
    }
}
