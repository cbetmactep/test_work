<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\IngredientType;

/**
 * ContactForm is the model behind the contact form.
 */
class Ingredient extends \yii\db\ActiveRecord
{
    public static function tableName() 
    {
        return '{{ingredient}}';
    }

    public function getIngredientType()
    {
        return $this->hasOne(IngredientType::class, ['id' => 'type_id']);
    }

}