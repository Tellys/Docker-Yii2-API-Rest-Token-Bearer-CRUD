<?php

namespace app\controllers;

use app\models\Product;
use yii\data\ActiveDataProvider;
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

    /* public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']); // Desactiva la acción de listado automático
        return $actions;
    } */

    public function actionPagination()
    {
        //preparing the query
        $query = Product::find();
        // get the total number of users
        $count = $query->count();
        //creating the pagination object
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 10]);
        //limit the query using the pagination and retrieve the users
        $models = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return [
            'pagination' => $pagination,
            'links' => $pagination->links,
            'totalCount' => $pagination->totalCount,
            'defaultPageSize'=> $pagination->defaultPageSize,
            'items' => $models,
            //totalCount
        ];
    }
}
