<?php

namespace app\controllers;

use app\models\PersonalAccessTtoken;
use yii\rest\Controller;
use Yii;

class PersonalAccessTtokenController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
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
