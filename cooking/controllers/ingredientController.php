<?php
include_once 'model/Ingredient.php';

class IngredientController
{
    public function getAll() 
    {
        $ingredient = new Ingredient();
        $ingredients = $ingredient->getAll();
        $data = array();
        $count = $ingredients->num_rows;
        $string = array();

        for ($i = 0; $i < $count; $i++) {
            $row = $ingredients->fetch_array();
            $string = array(
                'id' => $row[0],
                'name' => $row[1],
                'unit' => $row[2]
            );
        array_push($data, $string);
        }
        
    return json_encode($data, JSON_UNESCAPED_UNICODE);       
    }   
}
?>