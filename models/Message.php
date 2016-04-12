<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table 'message'
 * Message belongs to channel and has one author (from 'user' table)
 */

class Message extends ActiveRecord
{

    /**
     * Declares validation rules
     *
     * @return array Array of validation rules
     */
    public function rules() {
      return [
          [['body', 'user_id', 'channel_id'], 'required']
      ];
    }

    /**
     * Declares relation with 'user' table.
     *
     * @return yii\db\ActiveQuery Query instance
     */
    public function getAuthor() {
      return $this->hasOne(User::className(), [ 'id' => 'user_id' ]);
    }

    /**
     * Declares relation with 'channel' table.
     *
     * @return yii\db\ActiveQuery Query instance
     */
    public function getChannel() {
      return $this->hasOne(Channel::className(), [ 'id' => 'channel_id' ]);
    }

    /**
     * Set author of the message
     * 
     * @param app\models\User $authorauthoe of the message
     * @return app\models\Message message itself
     */
    public function setAuthor(User $author) {
      $this->user_id = $author->id;
      return $this;
    }

    /**
     * Sets channel
     *
     * @param app\models\Channel $channel channel model
     * @return app\models\Message message itself
     */
    public function addToChannel(Channel $channel) {
      $this->channel_id = $channel->id;
      return $this;
    }

    /**
     * Called before saving record to set created_at property
     */
    public function beforeSave($insert) {
      $this->created_at = time();

      return parent::beforeSave($insert);
    }

    /**
     * Returns creation datatime in human readable format
     * Example: Apr 10 2016 15:54:35
     *
     * @return string Formatted value
     */
    public function getCreatedAt() {
      return gmdate('M d Y H:i:s', $this->created_at);
    }
}
