<?php

namespace app\controllers;

use app\models\User;

class UserController extends \yii\rest\ActiveController
{
    public $modelClass = User::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }
}
