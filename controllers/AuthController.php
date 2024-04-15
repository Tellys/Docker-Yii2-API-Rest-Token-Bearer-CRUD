<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\rest\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $username = Yii::$app->request->post('name');
        $password = Yii::$app->request->post('password');

        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            // Generar y devolver un token de acceso
            $token = Yii::$app->security->generateRandomString();
            $user->auth_key = $token;
            $user->save();

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['token' => $token];
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Usuario o contraseña incorrectos'];
        }
    }

    public function actionLogout()
    {
        $user = Yii::$app->user->identity;
        $user->auth_key = null;
        $user->save();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['message' => 'Has cerrado sesión exitosamente'];
    }
}
