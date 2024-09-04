<?php
spl_autoload_register();

class Composition
{
    public $recipeId;
    public $counts;
    public $table = 'compositions';
    public $name;
    public $unit;

    public function getByRecipeId()
    {
        $sql = "SELECT ingredients.name,
        compositions.counts, ingredients.unit 
        FROM $this->table 
        JOIN ingredients 
        ON ingredients.id=compositions.ingredient_id 
        WHERE recipe_id=".$this->recipeId;
        return Database::connect()->query($sql);
    }
    
    public function createComposition() 
    {
        $sql = "INSERT INTO $this->table (recipe_id, 
        ingredient_id, counts) VALUES (?, ?, ?)";
        $stmt = Database:: connect()->prepare($sql);
        $stmt->bind_param("iis", $this->recipeId, 
            $this->ingredientId, $this->counts);
            if ($stmt->execute()) {
                echo "hooray";
            };
    }
}
?>