<?php

namespace app\controllers;

use app\filters\BearerAuth;
use app\models\Product;
use Yii;
use yii\data\Pagination;
use yii\web\Response;

class ProductController extends \yii\rest\ActiveController
{
    public $modelClass = Product::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
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
        unset($actions['index'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        Yii::$app->user->enableSession = false;
        $myRequest = Yii::$app->getRequest();

        $query = Product::find()
            //->joinWith('user', true, 'INNER JOIN')
            //->joinWith('user')
            ->with(['user']);

        if ($myRequest->getQueryParam('user_id')) {
            $userIdParam = $myRequest->getQueryParam('user_id');
            $query->where(['user_id' => $userIdParam]);
        }

        $r = $query->all();

        foreach ($r as $k => $v) {
            $r[$k]['user_id'] = $v->user;
        }

        return $r;
    }

    public function actionPagination()
    {
        Yii::$app->user->enableSession = false;

        $query = Product::find()->with('user');
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 10]);

        $query = $query->offset($pagination->offset)
            ->limit($pagination->limit);

        $myRequest = Yii::$app->getRequest();

        if ($myRequest->getQueryParam('user_id')) {
            $userIdParam = $myRequest->getQueryParam('user_id');
            $query->where(['user_id' => $userIdParam]);
        }

        $r = $query->all();

        foreach ($r as $k => $v) {
            $r[$k]['user_id'] = $v->user;
        }
        return [
            'pagination' => $pagination,
            'links' => $pagination->links,
            'totalCount' => $pagination->totalCount,
            'defaultPageSize' => $pagination->defaultPageSize,
            'items' => $r,
        ];
    }

    public function actionDelete($id)
    {
        try {
            return Product::findOne($id)->delete();
        } catch (\Throwable $th) {
            Yii::$app->response->statusCode = 401;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $th;
        }
    }
}
