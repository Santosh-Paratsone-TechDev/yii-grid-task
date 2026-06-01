<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grid_configurations".
 *
 * @property int $id
 * @property int $user_id
 * @property string $grid_key
 * @property string $column_name
 * @property string|null $display_name
 * @property int|null $is_visible
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Users $user
 */
class GridConfigurations extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grid_configurations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['display_name', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_visible'], 'default', 'value' => 1],
            [['user_id', 'grid_key', 'column_name'], 'required'],
            [['user_id', 'is_visible', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['grid_key'], 'string', 'max' => 100],
            [['column_name', 'display_name'], 'string', 'max' => 255],
            [['user_id', 'grid_key', 'column_name'], 'unique', 'targetAttribute' => ['user_id', 'grid_key', 'column_name']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'grid_key' => 'Grid Key',
            'column_name' => 'Column Name',
            'display_name' => 'Display Name',
            'is_visible' => 'Is Visible',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

}
