<?php

namespace app\controllers;

use app\models\PersonalAccessTtoken;
use Yii;
use app\models\User;
use yii\rest\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex(){
        return ['fun index'=> true];
    }


    public function actionLogin()
    {
        $email = Yii::$app->request->post('email');
        $password = Yii::$app->request->post('password');

        $user = User::findOne(['email' => $email]);
        if ($user && $user->validatePassword($password)) {
            
            $token = new PersonalAccessTtokenController();
            $token->generate($user);

            var_dump($token);
            return;
            
            //$token = Yii::$app->security->generateRandomString();
            $user->auth_key = $token->token;
            $user->save();

            return ['token' => $token->token];
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Correo electrónico o contraseña incorrectos'];
        }
    }

    public function actionLogout()
    {
        $user = Yii::$app->user->identity;
        if ($user !== null) {
            
            $token = new PersonalAccessTtokenController();
            $token->kill($user);
            
            $user->access_token = null;
            $user->save();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['message' => 'Sesión cerrada exitosamente'];
    }

    // public function actionRefreshToken(){
    // $user = User::find()->where(['refreshToken' => $this->request->getBodyParam('refreshToken'))->one();
    // $user->oldAccessToken = $user->accessToken;
    // $user->refreshToken = build a new token;
    // $user->accessToken = build a new token;

    // // save your user

    // // return both tokens
    // return [
    //      'accessToken' => $user->accessToken,
    //      'refreshToken' => $user->refreshToken
    // ];
    // }
}
