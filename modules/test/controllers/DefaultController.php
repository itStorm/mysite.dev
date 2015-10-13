<?php

namespace app\modules\test\controllers;

use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package app\modules\test\controllers
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [User::ROLE_NAME_ADMIN],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
