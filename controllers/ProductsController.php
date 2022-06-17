<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\components\RestController;

class ProductsController extends RestController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index'  => ['post'],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $param = Json::decode(file_get_contents('php://input'));
        $constructor = new \app\models\Constructor;
        if (!isset($param['query'])) {
            return ['error' => 'Query string should not be empty'];
        }
        $constructor->query = $param['query'];
        if ($constructor->validate()) {
            $result = $constructor->run();
        } else {
            $result = $constructor->errors;
        }
        return $result;
    }
}
