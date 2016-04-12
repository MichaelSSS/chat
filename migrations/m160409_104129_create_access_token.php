<?php

use yii\db\Migration;

class m160409_104129_create_access_token extends Migration
{
    public function up()
    {
        $this->createTable('access_token', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
            'user_id' => 'INTEGER NOT NULL',
            'token' => 'VARCHAR(255) NOT NULL',
            'FOREIGN KEY(user_id) REFERENCES user(id)'
        ]);
    }

    public function down()
    {
        $this->dropTable('access_token');
    }
}
