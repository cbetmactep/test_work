<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Ingredient;

/**
 * ContactForm is the model behind the contact form.
 */
class IngredientType extends \yii\db\ActiveRecord
{
    
    public static function tableName() 
    {
        return '{{ingredient_type}}';
    }

    public function getIngredients()
    {
        return $this->hasMany(Ingredient::class, ['type_id' => 'id']);
    }

}