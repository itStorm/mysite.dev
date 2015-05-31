<?php

namespace app\modules\user\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 */
class User extends ActiveRecord implements IdentityInterface
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'users';
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
			'id' => 'ID',
			'username' => 'Username',
			'email' => 'Email',
			'password_hash' => 'Password Hash',
			'auth_key' => 'Auth Key',
		];
	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			// Для новой записи пишем всегда какой-нибудь ключ
			if ($insert) {
				$this->setNewAuthKey();
			}
			return true;
		}
		return false;
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this->auth_key;
	}

	/**
     * Проверить ключ для пользователя по (авторизация по cookie)
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->auth_key === $authKey;
	}

	/**
	 * Проверить пароль для пользователя
	 * @param  string  $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	/**
	 * Наити пользователя по почте
	 * @param  string      $email
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
	public static function findIdentity($id) {
		return static::findOne($id);
	}

	/**
     * Найти пользователя по токену (авторизация по прямой ссылке)
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
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
     */
    public function setNewAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}
