<?php

namespace app\modules\main\controllers;

use Yii;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\main\models\ContactForm;
use app\modules\article\models\Article;
use app\modules\user\models\User;
use common\libs\safedata\SafeDataFinder;
use yii\web\ErrorAction;

class DefaultController extends Controller
{
    /**
     * Количество статей на странице
     */
    const ARTICLES_COUNT_PER_PAGE = 6;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['contact', 'about'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['contact'],
                        'roles'   => [User::ROLE_NAME_ADMIN],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['about'],
                        'roles'   => [User::ROLE_NAME_ADMIN],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error'   => [
                'class' => ErrorAction::className(),
            ],
            'captcha' => [
                'class'           => CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Главная страница
     * @return string
     */
    public function actionIndex()
    {
        $articles = Article::find()
            ->where([
                SafeDataFinder::FIELD_IS_ENABLED => SafeDataFinder::IS_ENABLED,
                SafeDataFinder::FIELD_IS_DELETED => SafeDataFinder::NOT_DELETED,
            ])
            ->orderBy(['published_date' => SORT_DESC])
            ->limit(self::ARTICLES_COUNT_PER_PAGE)
            ->all();

        return $this->render('index', [
            'articles' => $articles
        ]);
    }

    /**
     * Обратная связь
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * О проекте
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionAgreement()
    {
        return $this->render('agreement');
    }
}
