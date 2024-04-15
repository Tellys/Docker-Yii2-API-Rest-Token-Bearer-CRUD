<?php

namespace app\controllers;

use app\models\User;
use yii\data\Pagination;

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
}
