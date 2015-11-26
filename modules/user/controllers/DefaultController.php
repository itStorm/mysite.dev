<?php

namespace app\modules\user\controllers;

use app\modules\user\models\GetConfirmationLinkForm;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\modules\user\models\LoginForm;
use app\modules\user\models\RegistrationForm;
use yii\captcha\CaptchaAction;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class DefaultController
 * @package app\modules\user\controllers
 */
class DefaultController extends Controller
{
    public function actions()
    {
        return [
            'captcha' => [
                'class'           => CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'logout', 'get-confirmation-link'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['get-confirmation-link'],
                        'roles'   => ['?'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Профиль пользователя
     * @return string
     */
    public function actionIndex()
    {
        /** @var User $user */
        $user = \Yii::$app->getUser()->getIdentity();

        return $this->render('index', [
            'model' => $user,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!$user = User::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('app', 'User not found' . '...'));
        } elseif (\Yii::$app->getUser()->id == $user->id) {
            $this->redirect(['/user']);
        }

        return $this->render('view', [
            'model' => $user,
        ]);
    }

    /**
     * Сраница входа
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Экшен выхода
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Страница регистрации
     * @return string
     */
    public function actionRegistration()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->registration()) {
            return $this->render('registration_success');
        } else {
            return $this->render('registration', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Подтвержение почты
     * @param string $emailConfirm
     * @param string $email
     * @return string string
     * @throws NotFoundHttpException
     */
    public function actionEmailConfirm($emailConfirm, $email)
    {
        /** @var User $user */
        if (!$email) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        } elseif (!($user = User::findByEmail($email))) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        if ($user->is_enabled) {
            \Yii::$app->getSession()->setFlash('userAlreadyActivated');
        } elseif ($emailConfirm == $user->email_confirm) {
            \Yii::$app->getSession()->setFlash('successActivation');
            $user->confirm();
        } else {
            \Yii::$app->getSession()->setFlash('errorActivationCode');
            $this->redirect(['/user/default/get-confirmation-link']);
        }

        return $this->render('email_confirm');
    }

    /**
     * Посторная отправка ссылки
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGetConfirmationLink()
    {
        if (!\Yii::$app->getUser()->isGuest) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $model = new GetConfirmationLinkForm();
        if ($model->load(Yii::$app->request->post()) && $model->sendNewConfirmationLink()) {
            \Yii::$app->getSession()->setFlash('sentNewConfirmationLink');
        }

        return $this->render('get_confirmation_link', [
            'model' => $model,
        ]);
    }
}
