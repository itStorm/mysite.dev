<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;


/**
 * Class GetConfirmationLinkForm
 * @package app\modules\user\models
 */
class GetConfirmationLinkForm extends Model
{
    public $email;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],

            ['verifyCode', 'captcha', 'captchaAction' => '/user/default/captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'      => Yii::t('app', 'Email'),
            'verifyCode' => Yii::t('app', 'Verify Code'),
        ];
    }

    /**
     * Отправить новую ссылку на восстановление
     * @return bool
     */
    public function sendNewConfirmationLink()
    {
        if (!$this->validate()) {
            return false;
        }
        /** @var User $user */
        $user = User::findByEmail($this->email);
        if ($user && !$user->is_enabled) {
            $user->setEmailConfirm()
                ->save();
            $user->sendEmailConfirm();
        }

        return true;
    }
}
