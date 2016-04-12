<?php

use yii\db\Migration;

class m160408_145921_create_initial_tables extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
            'name' => 'VARCHAR(32) NOT NULL',
        ]);

        $this->createTable('channel', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
        ]);

        $this->createTable('message', [
            'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
            'user_id'  => 'INTEGER NOT NULL',
            'channel_id' => 'INTEGER NOT NULL',
            'body' => 'TEXT',
            'created_at' => 'INTEGER',
            'FOREIGN KEY (channel_id) REFERENCES channel(id)',
            'FOREIGN KEY (user_id) REFERENCES user(id)',
        ]);

        $this->createTable('channel_user', [
            'channel_id' => 'INTEGER NOT NULL',
            'user_id' => 'INTEGER NOT NULL',
            'PRIMARY KEY (channel_id, user_id)',
            'FOREIGN KEY (channel_id) REFERENCES channel(id)',
            'FOREIGN KEY (user_id) REFERENCES user(id)',
        ]);
    }

    public function down()
    {
        $this->dropTable('channel_user');
        $this->dropTable('message');
        $this->dropTable('channel');
        $this->dropTable('user');
    }
}
