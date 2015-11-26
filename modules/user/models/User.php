<?php

namespace app\modules\user\models;

use common\libs\safedata\SafeDataFinder;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use app\modules\article\models\Article;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string $email_confirm
 * @property bool $is_enabled
 * @property bool $is_deleted
 * @property int $created
 * @property int $updated
 * @property int $role
 * @property Article[] $articles
 */
class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_NAME_USER = 'user';
    const ROLE_NAME_MODERATOR = 'moderator';
    const ROLE_NAME_ADMIN = 'admin';

    const ROLE_USER = 1;
    const ROLE_MODERATOR = 5;
    const ROLE_ADMIN = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated',
                ],
                'value'      => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            ['password_hash', 'string', 'max' => 60],
            ['auth_key', 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'username'      => 'Username',
            'email'         => 'Email',
            'password_hash' => 'Password Hash',
            'auth_key'      => 'Auth Key',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Для новой записи пишем всегда какой-нибудь ключ и email confirmations
            if ($insert) {
                $this->setNewAuthKey()
                    ->setEmailConfirm();
            }

            return true;
        }

        return false;
    }

    /** @inheritdoc */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $this->sendEmailConfirm();
        }
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Проверить ключ для пользователя по (авторизация по cookie)
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Проверить пароль для пользователя
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Наити пользователя по почте
     * @param  string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Найти по id
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Найти пользователя по токену (авторизация по прямой ссылке)
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    /**
     * Перегинерировать хэш для нового пароля
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);

        return $this;
    }

    /**
     * Генерация ключа для авторизации по cookie
     * @return $this
     */
    public function setNewAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();

        return $this;
    }

    /**
     * @return ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * Генерация токена для подтверждение почты
     * @return $this
     */
    public function setEmailConfirm()
    {
        $this->email_confirm = Yii::$app->security->generateRandomString();

        return $this;
    }

    /**
     * Отправить письмо с подтверждением email, если есть токен
     * @return bool
     */
    public function sendEmailConfirm()
    {
        if (!$this->email_confirm) {
            return false;
        }

        return Yii::$app->mailer->compose('confirm_email', [
            'email' => $this->email,
            'link'  => $this->getUrlEmailConfirm(),
        ])
            ->setTo($this->email)
            ->setFrom([Yii::$app->params['infoEmail'] => $this->email])
            ->setSubject('Email confirmation')
            ->send();
    }

    /**
     * Подтвердить пользователя
     * @return bool
     */
    public function confirm()
    {
        $this->is_enabled = SafeDataFinder::IS_ENABLED;
        $this->email_confirm = '';

        return $this->save();
    }

    /**
     * Получить Url
     * @param boolean|string $scheme the URI scheme to use in the generated URL
     * @return string
     */
    public function getUrlView($scheme = false)
    {
        return Url::to(['/user/default/view', 'id' => $this->id], $scheme);
    }

    /**
     * Получить Url подтверждения регистрации
     * @param boolean|string $scheme the URI scheme to use in the generated URL
     * @return string
     */
    public function getUrlEmailConfirm($scheme = true)
    {
        return Url::to(['/user/default/email-confirm', 'emailConfirm' => $this->email_confirm, 'email' => $this->email], $scheme);
    }
}
