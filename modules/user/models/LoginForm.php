<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],

            ['password', 'required'],
            ['password', 'validatePassword'],

            ['rememberMe', 'boolean'],


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'      => Yii::t('app', 'Email'),
            'password'   => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember Me'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('app', 'Incorrect email or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided email and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        // Не прошла проверка логин/пароль
        if (!$this->validate()) {
            return false;
        }
        if (!$this->getUser()->is_enabled) {
            Yii::$app->getSession()->setFlash('userNotActivate');

            return false;
        } elseif ($this->getUser()->is_deleted) {
            Yii::$app->getSession()->setFlash('userIsDeleted');

            return false;
        }

        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::findByEmail($this->email);
        }

        return $this->user;
    }
}
