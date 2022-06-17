<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class ConstructorController extends Controller
{

    public function actionIndex(string $query)
    {
        $constructor = new \app\models\Constructor;
        $constructor->query = $query;
        if ($constructor->validate()) {
            $result = $constructor->run();
        } else {
            $result = $constructor->errors;
        }
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return ExitCode::OK;
    }
}
