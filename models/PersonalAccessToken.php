<?php

namespace app\models;

use app\filters\BearerAuth;
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
class PersonalAccessToken extends \yii\db\ActiveRecord
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

    public static function generate($user)
    {
        $date = date('Y-m-d H:i:s');

        $token = new PersonalAccessToken();
        $token->user_id = $user->id;
        $token->tokenable_type = 'App\Models\User';
        $token->tokenable_id = 1;
        $token->token = Yii::$app->security->generateRandomString();
        $token->abilities = '["*"]';
        $token->last_used_at = $date;
        $token->expires_at = date('Y-m-d H:i:s', strtotime('+60 minutes'));
        $token->created_at = $date;
        //$token->updated_at = null;
        $token->save();
        return $token;
    }

    public static function kill()
    {
        try {
            $token = BearerAuth::getToken();
            $token = PersonalAccessToken::find()->where(['token' => (explode('|', $token))[1]])->one();

            $user = User::findOne(['id' => $token->user_id]);
            $user->auth_key = null;
            $user->save(false);

            PersonalAccessToken::deleteAll(['user_id' => $token->user_id]);
            return true;
        } catch (\Exception $th) {
            return false;
        }
    }

    public static function isValidToken($token)
    {
        try {
            return PersonalAccessToken::find()
                ->where(['token' => (explode('|', $token))[1]])
                ->andWhere(['>', 'expires_at', date("Y-m-d H:i:s")])
                ->one();
        } catch (\Throwable $th) {
            return false;
        }
    }
}
