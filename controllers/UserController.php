<?php

namespace app\controllers;

use app\filters\BearerAuth;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\web\Response;

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

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => BearerAuth::class,
            //'except' => ['login'],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        return $actions;
    }

    public function actionPagination()
    {

        $query = User::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 10]);

        $query = $query->offset($pagination->offset)
            ->limit($pagination->limit);

        $r = $query->all();

        return [
            'pagination' => $pagination,
            'links' => $pagination->links,
            'totalCount' => $pagination->totalCount,
            'defaultPageSize' => $pagination->defaultPageSize,
            'items' => $r,
            //totalCount
        ];
    }

    public function actionDelete($id)
    {
        try {
            return User::findOne($id)->delete();
        } catch (\Throwable $th) {
            Yii::$app->response->statusCode = 401;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $th;
        }
    }
}
