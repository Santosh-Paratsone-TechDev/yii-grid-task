<?php

use yii\db\Migration;

class m260531_000001_create_users_table extends Migration {
    public function safeUp() {
        $this->createTable('{{%users}}', [
            'id' => $this->bigPrimaryKey(),

            'username' => $this->string(150)->notNull(),
            'email' => $this->string(255)->notNull(),

            'password_hash' => $this->string(255)->notNull(),
            'auth_key' => $this->string(64),
            'access_token' => $this->string(255),

            'full_name' => $this->string(255),
            'role' => $this->string(50)->defaultValue('user'),

            'is_active' => $this->tinyInteger(1)->defaultValue(1),
            'is_deleted' => $this->tinyInteger(1)->defaultValue(0),

            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex('idx_users_username', '{{%users}}', 'username', true);
        $this->createIndex('idx_users_email', '{{%users}}', 'email', true);
    }

    public function safeDown() {
        $this->dropTable('{{%users}}');
    }
}
