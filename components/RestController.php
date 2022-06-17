<?php

namespace app\components;

use yii\rest\Controller;

class RestController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST'],
                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Max-Age' => 300,
                ],
            ],

        ]);
    }
}
