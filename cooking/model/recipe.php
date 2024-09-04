<?php
spl_autoload_register();

class Recipe 
{
  public $id;
  public $title;
  public $cookId;
  public $steps;
  public $picture;
  public $table = 'recipes';
  public $composition;
  public $surname;
  public $name;

  public  function getAll() 
  {
    $sql = "SELECT recipes.id, recipes.title, 
    cooks.surname, cooks.name, recipes.picture 
    FROM $this->table 
    JOIN cooks ON cooks.id=recipes.cook_id"; 

    $result = Database::connect()->query($sql);
    $count = $result->num_rows;
    $data = array();

    for ($i = 0; $i < $count; $i++) {
      $row = $result->fetch_array();
      $string = array(
        "id" => $row[0],
        "title" => $row[1],
        "surname" => $row[2],
        "name" => $row[3],
        "picture" => $row[4]
         );
      array_push($data, $string);
    }

    return $data;        
  }

  public function getRecipeById() 
  {
    $sql = "SELECT recipes.id, recipes.title, 
    recipes.steps, recipes.picture, 
    cooks.surname, cooks.name
    FROM $this->table
    JOIN cooks ON cooks.id=recipes.cook_id 
    WHERE recipes.id=".$this->id; 
    $result = Database::connect()->query($sql);
  
    $row = $result->fetch_array();
    $array1 = array(
      "id" =>$row[0],
      "title" => $row[1],
      "steps" => $row[2],
      "picture" => $row[3],
      "surname" => $row[4],
      "name" => $row[5],
      "composition"
     );

    $array2 = array();
     
    $this->composition = new Composition();
    $this->composition->recipeId = $this->id;
    $result = $this->composition->getByRecipeId();
    $count = $result->num_rows;

    for ($i = 0; $i < $count; $i++) {
      $row =  $result->fetch_array();
      $array = array(
        "name" => $row[0],
        "count" => $row[1],
        "unit" => $row[2]
      );
      array_push($array2, $array);
    }

    $data = array();
    array_push($data, $array1);
    array_push($data, $array2);

    return $data;
  }

  public function getRecipesByCook()
  {
    $sql = "SELECT recipes.id, recipes.title,  
    recipes.steps, recipes.picture,
    ingredients.name,
    compositions.counts, ingredients.unit 
    FROM $this->table 
    JOIN compositions ON compositions.recipe_id= recipes.id 
    JOIN ingredients ON ingredients.id=
    compositions.ingredient_id 
    WHERE cook_id=$this->cookId";

    $result = Database::connect()->query($sql);
      
    $data = array();
    $num = -1;
    $id = 0;

    $arr2 = array();
    $arr1 = array();
    $count = $result->num_rows;
    
    for ($i = 0; $i < $count; $i++) {
       $row = $result->fetch_array();
       
      if ($id != $row[0]) {
        $arr1["recipe"] = [
        "id" => $row[0],
        "title" => $row[1],
        "steps" => $row[2],
        "picture" => $row[3],
        "composition" => $arr2
        ]; 
       
        $arr2 = array(
            "name" => $row[4],
            "counts" => $row[5],
            "unit" => $row[6],
        );

        array_push($arr1["recipe"]["composition"], $arr2);
        array_push($data, $arr1);   
        $id = $row[0];
        $num++;
      }
      else {
        $arr3 = array(
          "name" => $row[4],
          "counts" => $row[5],
          "unit" => $row[6]
          );
        array_push($data[$num]["recipe"]["composition"], $arr3);
      }
    }

    return $data;
  }

  public function createRecipe() 
  {
    $sql = "INSERT INTO $this->table (title, cook_id, 
      steps, picture) VALUES (?, ?, ?, ?)";

    if ($stmt = Database::connect()->prepare($sql)) {
      $stmt->bind_param("siss", $this->title, 
      $this->cookId, $this->steps, $this->picture);
      $stmt->execute(); 
      $sql = "SELECT MAX(id) FROM $this->table";
      $result =  Database::connect()->query($sql);
      $row = $result->fetch_array();
      $id = (int)$row[0];
    return $id;
    } 
  }
}
?>