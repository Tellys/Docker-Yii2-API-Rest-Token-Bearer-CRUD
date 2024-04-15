<?php

namespace app\models;

use floor12\phone\PhoneValidator;
use Yii;
use yii\web\IdentityInterface;
use yiibr\brvalidator\CpfValidator;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string|null $sexo
 * @property string|null $image
 * @property int $ssn
 * @property string|null $address
 * @property string|null $address_neighborhood
 * @property int|null $address_num
 * @property string|null $address_complement
 * @property int|null $zip_code
 * @property string|null $city
 * @property string|null $state
 * @property string|null $cell_phone
 * @property string|null $cell_phone_verified_at
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password_hash
 * @property string|null $auth_key
 *
 * @property Product[] $products
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        //Yii::setPathOfAlias('brval', Yii::getPathOfAlias('vendor.igorsantos07.yii-br-validators');

        return [
            [['name', 'ssn', 'email', 'password_hash'], 'required'],
            [['ssn', 'address_num', 'zip_code'], 'integer',],
            [['cell_phone_verified_at', 'email_verified_at'], 'safe'],
            [['name', 'sexo', 'image', 'address', 'address_neighborhood', 'address_complement', 'city', 'state', 'cell_phone', 'email', 'password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['name'], 'unique'],
            [['ssn'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['ssn'], CpfValidator::class],
            [['cell_phone'], PhoneValidator::class, 'skipOnEmpty' => true],
            [['image'], 'url'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sexo' => 'Sexo',
            'image' => 'Image',
            'ssn' => 'Ssn',
            'address' => 'Address',
            'address_neighborhood' => 'Address Neighborhood',
            'address_num' => 'Address Num',
            'address_complement' => 'Address Complement',
            'zip_code' => 'Zip Code',
            'city' => 'City',
            'state' => 'State',
            'cell_phone' => 'Cell Phone',
            'cell_phone_verified_at' => 'Cell Phone Verified At',
            'email' => 'Email',
            'email_verified_at' => 'Email Verified At',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery|ProductQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function findByUserEmail($userEmail)
    {
        return static::findOne(['email' => $userEmail]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function generate($user)
    {
        $date = date('Y-m-d H:i:s');

        $token = new PersonalAccessTtoken();
        $token->user_id = $user->id;
        $token->tokenable_type = 'App\Models\User';
        $token->tokenable_id = 1;
        $token->token = Yii::$app->security->generateRandomString();
        $token->abilities = '["*"]';
        $token->last_used_at = $date;
        $token->expires_at = date('Y-m-d H:i:s', strtotime('+60 minutes'));
        $token->created_at = $date;
        //$token->updated_at = null;
        return $token->save();
    }

    public function kill($user)
    {
        $date = date('Y-m-d H:i:s');

        $token = (new PersonalAccessTtoken())::find()->where(['id' => $user->id])->one();
        $token->last_used_at = $date;
        $token->expires_at = $date;
        $token->created_at = $date;
        //$token->updated_at = null;
        return $token->save();
    }
}
