<?php

namespace app\controllers;

use app\models\PersonalAccessToken;
use yii\rest\Controller;
use Yii;

class PersonalAccessTokenController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
