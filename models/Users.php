<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string|null $auth_key
 * @property string|null $access_token
 * @property string|null $full_name
 * @property string|null $role
 * @property int|null $is_active
 * @property int|null $is_deleted
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ClaimDetails[] $claimDetails
 * @property ClaimDetails[] $claimDetails0
 * @property Claims[] $claims
 * @property Claims[] $claims0
 * @property GridConfigurations[] $gridConfigurations
 * @property GridConfigurations[] $gridConfigurations0
 * @property GridConfigurations[] $gridConfigurations1
 */
class Users extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auth_key', 'access_token', 'full_name', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['role'], 'default', 'value' => 'user'],
            [['is_active'], 'default', 'value' => 1],
            [['is_deleted'], 'default', 'value' => 0],
            [['username', 'email', 'password_hash'], 'required'],
            [['is_active', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 150],
            [['email', 'password_hash', 'access_token', 'full_name'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 64],
            [['role'], 'string', 'max' => 50],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'full_name' => 'Full Name',
            'role' => 'Role',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
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
        return $this->hasMany(ClaimDetails::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ClaimDetails0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClaimDetails0()
    {
        return $this->hasMany(ClaimDetails::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Claims]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClaims()
    {
        return $this->hasMany(Claims::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Claims0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClaims0()
    {
        return $this->hasMany(Claims::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[GridConfigurations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGridConfigurations()
    {
        return $this->hasMany(GridConfigurations::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[GridConfigurations0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGridConfigurations0()
    {
        return $this->hasMany(GridConfigurations::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[GridConfigurations1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGridConfigurations1()
    {
        return $this->hasMany(GridConfigurations::class, ['updated_by' => 'id']);
    }

}
