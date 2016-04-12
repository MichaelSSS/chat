<?php

namespace auth\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\User;

/**
 * This is the model class for table 'access_token'
 */

class AccessToken extends ActiveRecord
{
  /**
   * Length of the secure part of token
   */
  const SECURE_PART_LENGTH = 32;

  /**
   * Declares validation rules
   *
   * @return array Array of validation rules
   */
  public function rules() {
    return [
      [['user_id', 'token'], 'required']
    ];
  }

  /**
   * Sets the given user for the token
   *
   * @param app\base\User $user User instance
   */
  public function setUser(User $user) {
    $this->user_id = $user->id;
  }

  /**
   * Generates token and saves model
   *
   * @return boolean True is model was saved, false otherwise
   */
  public function generateAndSave() {
    $this->token = self::generateToken();
    return $this->save();
  }

  /**
   * Creates token for the given user
   *
   * @param app\base\User $user user for which to save token
   * @return api\auth\AccessToken|null Created token instance or null
   */
  public static function createFor(User $user) {
    $model = new static;
    $model->setUser($user);

    if($model->generateAndSave()) return $model;
    return null;
  }

  /**
   * Returns token value
   *
   * @return string
   */
  public static function generateToken() {
    $securePart = Yii::$app->getSecurity()->generateRandomString(self::SECURE_PART_LENGTH);
    return $securePart . '-' . uniqid();
  }
}
