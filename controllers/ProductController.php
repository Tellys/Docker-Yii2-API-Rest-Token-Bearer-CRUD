<?php

namespace app\controllers;

use app\models\Product;
use Yii;
use yii\data\Pagination;

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

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
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
            //totalCount
        ];
    }
}
