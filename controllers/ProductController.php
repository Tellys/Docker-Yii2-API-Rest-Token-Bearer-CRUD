<?php

namespace app\controllers;

use app\models\Product;

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
}
