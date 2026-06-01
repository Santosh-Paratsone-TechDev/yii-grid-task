<?php

use yii\db\Migration;

class m260531_000004_create_grid_configurations_table extends Migration {
    public function safeUp() {
        $this->createTable('{{%grid_configurations}}', [
            'id' => $this->bigPrimaryKey(),

            'user_id' => $this->bigInteger()->notNull(),
            'grid_key' => $this->string(100)->notNull(),
            'column_name' => $this->string(255)->notNull(),
            'display_name' => $this->string(255),
            'is_visible' => $this->tinyInteger(1)->defaultValue(1),

            'created_by' => $this->bigInteger(),
            'updated_by' => $this->bigInteger(),

            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex(
            'uniq_user_grid_column',
            '{{%grid_configurations}}',
            ['user_id', 'grid_key', 'column_name'],
            true
        );

        $this->addForeignKey(
            'grid_configurations_ibfk_1',
            '{{%grid_configurations}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'grid_configurations_ibfk_2',
            '{{%grid_configurations}}',
            'created_by',
            '{{%users}}',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            'grid_configurations_ibfk_3',
            '{{%grid_configurations}}',
            'updated_by',
            '{{%users}}',
            'id',
            'SET NULL'
        );
    }

    public function safeDown() {
        $this->dropForeignKey('grid_configurations_ibfk_1', '{{%grid_configurations}}');
        $this->dropForeignKey('grid_configurations_ibfk_2', '{{%grid_configurations}}');
        $this->dropForeignKey('grid_configurations_ibfk_3', '{{%grid_configurations}}');

        $this->dropTable('{{%grid_configurations}}');
    }
}
