<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "claims".
 *
 * @property int $id
 * @property string|null $file_number
 * @property string|null $manager_name
 * @property string|null $service_provider_name
 * @property string|null $claim_number
 * @property string|null $assignment_id
 * @property string|null $company_name
 * @property string|null $invoice_date
 * @property float|null $expenses
 * @property float|null $sale_tax
 * @property float|null $payment_amount
 * @property float|null $balance_amount
 * @property string|null $payment_date
 * @property float|null $loss_amount
 * @property float|null $orig_fee_schedule
 * @property float|null $orig_correction
 * @property float|null $orig_wyo_payment
 * @property float|null $orig_write_off
 * @property string|null $orig_adjusting_company
 * @property int|null $orig_days_os
 * @property string|null $orig_loss_type
 * @property string|null $curr_company_name
 * @property int|null $is_deleted
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ClaimDetails[] $claimDetails
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class Claims extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'claims';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_number', 'manager_name', 'service_provider_name', 'claim_number', 'assignment_id', 'company_name', 'invoice_date', 'expenses', 'sale_tax', 'payment_amount', 'balance_amount', 'payment_date', 'loss_amount', 'orig_fee_schedule', 'orig_correction', 'orig_wyo_payment', 'orig_write_off', 'orig_adjusting_company', 'orig_days_os', 'orig_loss_type', 'curr_company_name', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['invoice_date', 'payment_date', 'created_at', 'updated_at'], 'safe'],
            [['expenses', 'sale_tax', 'payment_amount', 'balance_amount', 'loss_amount', 'orig_fee_schedule', 'orig_correction', 'orig_wyo_payment', 'orig_write_off'], 'number'],
            [['orig_days_os', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['file_number', 'claim_number', 'assignment_id'], 'string', 'max' => 100],
            [['manager_name', 'service_provider_name', 'company_name', 'orig_adjusting_company', 'orig_loss_type', 'curr_company_name'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_number' => 'File Number',
            'manager_name' => 'Manager Name',
            'service_provider_name' => 'Service Provider Name',
            'claim_number' => 'Claim Number',
            'assignment_id' => 'Assignment ID',
            'company_name' => 'Company Name',
            'invoice_date' => 'Invoice Date',
            'expenses' => 'Expenses',
            'sale_tax' => 'Sale Tax',
            'payment_amount' => 'Payment Amount',
            'balance_amount' => 'Balance Amount',
            'payment_date' => 'Payment Date',
            'loss_amount' => 'Loss Amount',
            'orig_fee_schedule' => 'Orig Fee Schedule',
            'orig_correction' => 'Orig Correction',
            'orig_wyo_payment' => 'Orig Wyo Payment',
            'orig_write_off' => 'Orig Write Off',
            'orig_adjusting_company' => 'Orig Adjusting Company',
            'orig_days_os' => 'Orig Days Os',
            'orig_loss_type' => 'Orig Loss Type',
            'curr_company_name' => 'Curr Company Name',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ClaimDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClaimDetails()
    {
        return $this->hasMany(ClaimDetails::class, ['claim_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::class, ['id' => 'updated_by']);
    }

}
