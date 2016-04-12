<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table 'channel_user'
 * It is a junction table between 'channel' and 'user'
 */

class ChannelUser extends ActiveRecord
{
    /**
     * Declares validation rules
     *
     * @return array Array of validation rules
     */
    public function rules() {
      return [
          [['user_id', 'channel_id'], 'required']
      ];
    }
}
