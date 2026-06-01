<?php

use yii\db\Migration;

class m260531_000002_create_claims_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%claims}}', [
            'id' => $this->bigPrimaryKey(),

            'file_number' => $this->string(100),
            'manager_name' => $this->string(255),
            'service_provider_name' => $this->string(255),

            'claim_number' => $this->string(100),
            'assignment_id' => $this->string(100),

            'company_name' => $this->string(255),

            'invoice_date' => $this->date(),

            'expenses' => $this->decimal(12,2),
            'sale_tax' => $this->decimal(12,2),

            'payment_amount' => $this->decimal(12,2),
            'balance_amount' => $this->decimal(12,2),

            'payment_date' => $this->date(),

            'loss_amount' => $this->decimal(12,2),

            'orig_fee_schedule' => $this->decimal(12,2),
            'orig_correction' => $this->decimal(12,2),
            'orig_wyo_payment' => $this->decimal(12,2),
            'orig_write_off' => $this->decimal(12,2),
            'orig_adjusting_company' => $this->string(255),
            'orig_days_os' => $this->integer(),
            'orig_loss_type' => $this->string(255),
            'curr_company_name' => $this->string(255),

            'is_deleted' => $this->tinyInteger(1)->defaultValue(0),

            'created_by' => $this->bigInteger(),
            'updated_by' => $this->bigInteger(),

            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);

        // Indexes
        $this->createIndex('idx_file_number', '{{%claims}}', 'file_number');
        $this->createIndex('idx_claim_number', '{{%claims}}', 'claim_number');
        $this->createIndex('idx_invoice_date', '{{%claims}}', 'invoice_date');
        $this->createIndex('idx_payment_date', '{{%claims}}', 'payment_date');
        $this->createIndex('idx_company_name', '{{%claims}}', 'company_name');

        // Foreign keys
        $this->addForeignKey(
            'claims_ibfk_1',
            '{{%claims}}',
            'created_by',
            '{{%users}}',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            'claims_ibfk_2',
            '{{%claims}}',
            'updated_by',
            '{{%users}}',
            'id',
            'SET NULL'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('claims_ibfk_1', '{{%claims}}');
        $this->dropForeignKey('claims_ibfk_2', '{{%claims}}');

        $this->dropTable('{{%claims}}');
    }
}
