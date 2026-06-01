<?php

use yii\db\Migration;

class m260531_000003_create_claim_details_table extends Migration {
    public function safeUp() {
        $this->createTable('{{%claim_details}}', [
            'id' => $this->bigPrimaryKey(),

            'claim_id' => $this->bigInteger()->notNull(),

            'history_type' => $this->string(100),
            'trans_date' => $this->dateTime(),

            'item_name' => $this->string(255),
            'description' => $this->text(),
            'quantity' => $this->integer(),
            'unit_price' => $this->decimal(12, 2),
            'total' => $this->decimal(12, 2),

            'created_by' => $this->bigInteger(),
            'updated_by' => $this->bigInteger(),

            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);

        // Indexes
        $this->createIndex('idx_claim_id', '{{%claim_details}}', 'claim_id');
        $this->createIndex('idx_trans_date', '{{%claim_details}}', 'trans_date');

        // Foreign keys
        $this->addForeignKey(
            'claim_details_ibfk_1',
            '{{%claim_details}}',
            'claim_id',
            '{{%claims}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'claim_details_ibfk_2',
            '{{%claim_details}}',
            'created_by',
            '{{%users}}',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            'claim_details_ibfk_3',
            '{{%claim_details}}',
            'updated_by',
            '{{%users}}',
            'id',
            'SET NULL'
        );
    }

    public function safeDown() {
        $this->dropForeignKey('claim_details_ibfk_1', '{{%claim_details}}');
        $this->dropForeignKey('claim_details_ibfk_2', '{{%claim_details}}');
        $this->dropForeignKey('claim_details_ibfk_3', '{{%claim_details}}');

        $this->dropTable('{{%claim_details}}');
    }
}
