<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table 'channel'.
 * Channel is intermediate entity between users and messages
 * Channel can have many users and many messages. 
 */

class Channel extends ActiveRecord
{
  /**
   * Declares the relation with 'message' table
   *
   * @return yii\db\ActiveQuery Query instance
   */
  public function getMessages() {
    return $this->hasMany(Message::className(), [ 'channel_id' => 'id' ]);
  }

  /**
   * Declares the relation with 'channel_user' table
   *
   * @return yii\db\ActiveQuery Query instance
   */
  public function getUsers() {
    return $this->hasMany(ChannelUser::className(), [ 'channel_id' => 'id' ]);
  }

  /**
   * Gets or creates channel between given users
   * Currently it always creates new channel
   *
   * @param app\models\User $users,... users models
   * @return app\models\Channel Created Channel instance
   * @throws yii\db\Exception
   */
  public static function getChannel(User ...$users) {
    $channel = new static;
    $transaction = self::getDb()->beginTransaction();
    try {
      if (!$channel->save()) {
        throw new Exception('Failed to save channel');
      }
      $channel->add($users);
      $transaction->commit();

      return $channel;
    } catch(Exception $e) {
      $transaction->rollback();
      throw $e;
    }
  }

  /**
   * Adds users to channel
   *
   * @param array $users array of users models
   * @throws yii\db\Exception
   */
  public function add(array $users) {
    if ($this->isNewRecord) {
      throw new Exception('Channel should be persistent prior to adding users');
    }

    foreach($users as $user) { 
      if (!$user->linkToChannel($this)) {
        throw new Exception('Failed to add user to the channel');
      }
    }
  }
}
