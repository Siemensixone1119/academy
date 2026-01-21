<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class AdminUser extends ActiveRecord implements IdentityInterface
{
  public static function tableName()
  {
    return '{{%admin_users}}';
  }

  public static function findIdentity($id)
  {
    return static::findOne(['id' => $id]);
  }

  public static function findIdentityByAccessToken($token, $type = null)
  {
    // Логика для поиска по токену, если используется
  }

  public static function findByEmail($email)
  {
    return static::findOne(['email' => $email]);
  }

  public function validatePassword($password)
  {
    return Yii::$app->security->validatePassword($password, $this->password_hash);
  }

  public function getId()
  {
    return $this->id;
  }

  public function getAuthKey()
  {
    return $this->auth_key;
  }

  public function validateAuthKey($authKey)
  {
    return $this->auth_key === $authKey;
  }

  // Генерация ключа для аутентификации
  public function generateAuthKey()
  {
    $this->auth_key = Yii::$app->security->generateRandomString();
  }

  // Добавление валидации пароля и хэширования
  public function beforeSave($insert)
  {
    if ($this->isNewRecord) {
      $this->generateAuthKey(); // Генерация ключа при создании нового пользователя
    }

    return parent::beforeSave($insert);
  }
}
