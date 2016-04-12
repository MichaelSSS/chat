<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use auth\models\AccessToken;

/**
 * This is the model class for table 'user'.
 * User can have many access tokens. User can have many channels.
 * 
 * This is also identity class for token based authentication.
 * It's instance for the current user is available via Yii::$app->user->identity
 */

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * Declares validation rules
     *
     * @return array Array of validation rules
     */
    public function rules() {
        return [
            ['name', 'required']
        ];
    }

    /**
     * Declares relation with 'access_token' table
     *
     * @return yii\db\ActiveQuery Query instance
     */
    public function getTokens() {
        return $this->hasMany(AccessToken::className(), [ 'user_id' => 'id' ]);
    }

    /**
     * Declares relation with 'channel' table through 'channel_user' table
     *
     * @return yii\db\ActiveQuery Query instance
     */
    public function getChannels() {
        return $this->hasMany(Channel::className(), ['id' => 'channel_id'])
            ->viaTable('channel_user', ['user_id' => 'id']);
    }

    /**
     * Declares relation with 'access_token' table
     *
     * @return yii\db\ActiveQuery Query instance
     */
    public function getOrCreateToken() {
        $token = null;
        if (count($this->tokens)) {
            return $this->tokens[0];
        }
        return AccessToken::createFor($this);
    }

    /**
     * Links user with channel
     *
     * @param app\models\Channel Channel instance
     * @return boolean True on success, false if record was not saved
     */
    public function linkToChannel(Channel $channel) {
      $link = new ChannelUser;
      $link->user_id = $this->id;
      $link->channel_id = $channel->id;
      return $link->save();
    }

    /**
     * Returns user's incomming messages
     *
     * @param int|string|null $min_id if present returns messages having id greater than $min_id
     * @return array Array of Message models
     */
    public function getIncomingMessages($min_id = null) {
        $query = Message::find()
        ->joinWith(['author author', 'channel.users users'])
        ->with(['author'])
        ->where('users.user_id = :user_id AND author.id != :user_id')
        ->orderBy('message.created_at DESC')
        ->params([':user_id' => $this->id]);

        if (!empty($min_id)) {
            $query->andWhere('`message`.`id` > :min_id')
            ->addParams([':min_id' => $min_id]);
        }

        $provider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $provider->getModels();
    }

    /**
     * Finds user by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return app\models\User|null User object. Null is returned if user cannot be found
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token.
     * @return app\models\User|null User that has the given token.
     * Null is returned if token cannot be found
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        $token = AccessToken::find()->where(['token' => $token])->one();
        
        if (!$token) return null;
        return self::findOne($token->user_id);
    }

    /**
     * Returns user id
     * @return int User id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Required to implemnt UserIdentity interface
     *
     * @return null
     */
    public function getAuthKey() {
        return null;
    }

    /**
     * Required to implemnt UserIdentity interface
     *
     * @return false
     */
    public function validateAuthKey($authKey) {
        return false;
    }
}
