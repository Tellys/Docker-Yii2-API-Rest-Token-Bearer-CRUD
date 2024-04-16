<?php

namespace app\filters;

use app\models\PersonalAccessToken;
use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;

class BearerAuth extends ActionFilter
{
    public function beforeAction($action)
    {
        $accessToken = Yii::$app->request->headers->get('Authorization');
        if ($accessToken !== null && preg_match('/^Bearer\s+(.*?)$/', $accessToken, $matches)) {
            $token = $matches[1];
            if ($this->isValidToken($token)) {
                return true;
            }
        }

        throw new UnauthorizedHttpException('Acceso não autorizado. Token inválido.');
    }

    protected function isValidToken($token)
    {
        return PersonalAccessToken::isValidToken($token);
    }

    public static function getToken()
    {
        return Yii::$app->request->headers->get('Authorization');
    }
}
