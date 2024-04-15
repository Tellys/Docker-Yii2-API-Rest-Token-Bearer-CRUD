<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personal_access_token".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $tokenable_type
 * @property int|null $tokenable_id
 * @property string|null $token
 * @property string|null $abilities
 * @property string|null $last_used_at
 * @property string|null $expires_at
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 */
class PersonalAccessTtoken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personal_access_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'tokenable_id'], 'integer'],
            [['abilities'], 'string'],
            [['last_used_at', 'expires_at', 'created_at', 'updated_at'], 'safe'],
            [['tokenable_type'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 64],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'tokenable_type' => 'Tokenable Type',
            'tokenable_id' => 'Tokenable ID',
            'token' => 'Token',
            'abilities' => 'Abilities',
            'last_used_at' => 'Last Used At',
            'expires_at' => 'Expires At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
