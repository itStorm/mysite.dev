<?php

namespace app\modules\user\controllers;

use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\user\models\LoginForm;
use app\modules\user\models\RegistrationForm;
use yii\captcha\CaptchaAction;

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
				'class' => CaptchaAction::className(),
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index'],
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
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
		$user = \Yii::$app->getUser();
		/** @var User $model */
		$model = $user->getIdentity();

		return $this->render('index', [
			'model' => $model,
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
	public function actionRegistration() {
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
}
