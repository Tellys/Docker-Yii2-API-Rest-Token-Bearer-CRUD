<?php

namespace app\controllers;

use app\models\PersonalAccessToken;
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

    public function actionIndex()
    {
        return ['fun index' => true];
    }


    public function actionLogin()
    {
        try {
            $email = Yii::$app->request->post('email');
            $password = Yii::$app->request->post('password');

            $user = User::findOne(['email' => $email]);

            if (!$user->validatePassword($password)) {
                throw new \Exception('Invalid User or Password');
            }

            Yii::$app->user->login($user);

            $token = PersonalAccessToken::generate($user);

            $user->auth_key = $token->token;
            $user->save(false);

            $r = $token->toArray();
            unset($r['id']);
            $r['token'] = 'Bearer:' . $token->id . '|' . $token->token;

            PersonalAccessToken::isValidToken($r['token']);

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['data' => $r];
        } catch (\Throwable $e) {
            Yii::$app->response->statusCode = 401;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => ['Unauthorized', $e]];
        }
    }

    public function actionLogout()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!PersonalAccessToken::kill()) {
            return ['success' => 'No user Logged to a logout'];
        }
        return ['succeess' => 'User logout'];
    }

    public function actionRefreshToken()
    {
        return ['succeess' => 'Not develop'];
    }
}
