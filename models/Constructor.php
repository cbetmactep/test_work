<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Ingredient;

class Constructor extends Model {

    public $query;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['query', 'required', 'message' => 'Query string should not be empty'],
            ['query', 'match', 'pattern'=> '/^(d){1,}(c){1,}(i){1,}$/', 'message' => 'Invalid format query string'],

        ];
    }

    private function getIngredientData() {
        $ingredientDBData = Ingredient::find()->with('ingredientType')->all();
        if(empty($ingredientDBData)) {
            return [];
        }
        $ingredientArray = [];
        foreach($ingredientDBData as $ingredient) {
            if(isset($ingredient->ingredientType->code, $ingredient->ingredientType->title,$ingredient->title,$ingredient->price)) {
                $ingredientArray[$ingredient->ingredientType->code][] = [
                    'type'  => $ingredient->ingredientType->title,
                    'value' => $ingredient->title,
                    'price' => $ingredient->price
                ];
            }
        }
        return $ingredientArray;
    }

    private function prepareConstructorArrays($ingredientData, $query) {
        $constructorArray = [];
        foreach($ingredientData as $type => $ingregientsArray) {
            $countTypeIngredient = substr_count($query, $type);
            for($i=0;$i<$countTypeIngredient;++$i) {
                array_push($constructorArray, $ingregientsArray);
            }
        }
        return $constructorArray;
    }

    private function generateProductsCombinations($constructorIngredientsArray) {
        foreach (array_pop($constructorIngredientsArray) as $ingredients) {
            if (count($constructorIngredientsArray)) {
                foreach ($this->generateProductsCombinations($constructorIngredientsArray) as $productCombination) {
                    if(!in_array($ingredients, $productCombination)) {
                        yield array_merge([$ingredients], $productCombination);
                    }
                };
            } else {
                yield [$ingredients];
            }
        }
    }

    private function generateProducts($constructorIngredientsArray) {
        $products = [];
        foreach ($this->generateProductsCombinations($constructorIngredientsArray) as $ingredients) {
            $product = [];
            $price = 0;
            foreach($ingredients as $ingredient){
                $price += $ingredient['price'];
                unset($ingredient['price']);
                $product[] = $ingredient;
            }
            krsort($product);
            $products[] = [
                'products' => array_values($product),
                'price' => $price
            ];
        }
        return $products;
    }

    public function run() : array{
        $ingredientData = $this->getIngredientData();
        if(empty($ingredientData)) {
            return [];
        }

        $constructorIngredientsArray = $this->prepareConstructorArrays($ingredientData,  $this->query);

        if(empty($constructorIngredientsArray)) {
            return [];
        }

        $products = $this->generateProducts($constructorIngredientsArray);
        
        if(!empty($products)) {
            return $products;
        } 
        return [];
    }


}