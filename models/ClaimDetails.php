<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "claim_details".
 *
 * @property int $id
 * @property int $claim_id
 * @property string|null $history_type
 * @property string|null $trans_date
 * @property string|null $item_name
 * @property string|null $description
 * @property int|null $quantity
 * @property float|null $unit_price
 * @property float|null $total
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Claims $claim
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class ClaimDetails extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'claim_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['history_type', 'trans_date', 'item_name', 'description', 'quantity', 'unit_price', 'total', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['claim_id'], 'required'],
            [['claim_id', 'quantity', 'created_by', 'updated_by'], 'integer'],
            [['trans_date', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['unit_price', 'total'], 'number'],
            [['history_type'], 'string', 'max' => 100],
            [['item_name'], 'string', 'max' => 255],
            [['claim_id'], 'exist', 'skipOnError' => true, 'targetClass' => Claims::class, 'targetAttribute' => ['claim_id' => 'id']],
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
            'claim_id' => 'Claim ID',
            'history_type' => 'History Type',
            'trans_date' => 'Trans Date',
            'item_name' => 'Item Name',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'total' => 'Total',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Claim]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClaim()
    {
        return $this->hasOne(Claims::class, ['id' => 'claim_id']);
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
