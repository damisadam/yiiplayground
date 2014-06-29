<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\components\BaseController;

class SiteController extends BaseController
{
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only'  => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow'   => true,
						'roles'   => ['@'],
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

	public function actions() {
		return [
			'error'   => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class'           => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionIndex() {
		return $this->render('index');
	}

	public function actionLogin() {
		if (!\Yii::$app->user->isGuest) {
			$this->goHome();
		}

		$model = new LoginForm();
		if ($model->load($_POST) && $model->login()) {
			return $this->goBack();
		}
		else {
			return $this->render('login', [
					'model' => $model,
				]
			);
		}
	}

	public function actionLogout() {
		Yii::$app->user->logout();

		return $this->goHome();
	}

	public function actionAbout() {
		return $this->render('about');
	}
}
