<?php
include_once 'model/recipe.php';
include_once 'model/composition.php';
include_once 'model/auth.php';
include_once 'model/ingredient.php'; 
 
class RecipeController
{
  public function getAll() 
  {         
    $recipe = new Recipe();
    $recipes = $recipe->getAll();
    $page1 = "";

    foreach ($recipes as $array => $recipe) {
      extract($recipe);
      $pageMain .= file_get_contents('view/pageMain.php');
      $pageMain = str_replace('{{id}}', $id, $pageMain);
      $pageMain = str_replace('{{title}}', $title, $pageMain);
      $pageMain = str_replace('{{cook}}', $surname." ".$name, $pageMain);  
      $pageMain = str_replace('{{picture}}', $picture, $pageMain);            
    }  
    
    $blockVhod = $this->blockVhod();
    $layout = file_get_contents('layout.php');
    $layout = str_replace('{{vhod}}', $blockVhod, $layout);
    $layout = str_replace('{{content}}', $pageMain, $layout);
    
    echo  $layout; 
    exit();
  }

  public function getRecipeById($id) 
  {
    $recipe = new Recipe();
    $recipe->id = $id;
    $recipeNeed = $recipe->getRecipeById();
    extract($recipeNeed[0]);  
    $composition = "";
    $i = 1;
    
    foreach ($recipeNeed[1] as $need => $array) {
      foreach ($array as $item =>$value) {
        $br = "";
        if ($i%3 == 0) {
          $br = "<br>";
        }
      $composition .= $value." ". $br;
      $i++;
        }
      }
    
    $blockVhod = $this->blockVhod();
    $layout = file_get_contents('layout.php');
    $pageMore = file_get_contents('view/pageMore.php');
    $picture = substr($picture, 1);
    $picture = "'../".$picture;
    
    $pageMore = str_replace('{{title}}', $title, $pageMore);
    $pageMore = str_replace('{{composition}}', $composition, $pageMore);
    $pageMore = str_replace('{{steps}}', $steps, $pageMore);
    $pageMore = str_replace('{{picture}}', $picture, $pageMore);
    $pageMore = str_replace('{{cook}}', $surname." ". $name, $pageMore);
    $layout = str_replace('{{vhod}}', $blockVhod, $layout);
    $layout = str_replace('{{content}}', $pageMore, $layout);

    echo  $layout; 
    exit();           
  }
    
  public function createForm()
  {
    $ingredient = new Ingredient();
    $ingredients = $ingredient->getAll();
    $inputArray["compo"] = array();
    $input = "";
    $count =   count($ingredients);

    for ($i = 0; $i < $count; $i++) {
      $input .= $ingredients[$i]['ingredient']."
      <input type='text'  name='" 
      .$ingredients[$i]['id']."'>
      " .$ingredients[$i]['unit'] ."<br>";  
    } 

    $layout = file_get_contents('layout.php');         
    $pageCreateForm = file_get_contents('view/pageCreateForm.php');
    $pageCreateForm = str_replace('{{composition}}',
    $input, $pageCreateForm);
    $layout = str_replace('{{content}}',
    $pageCreateForm, $layout);

    echo  $layout;        
}

  public function createRecipe() 
  { 
    if (empty($_POST)) {
      $ingredient = new Ingredient();
      $ingredients = $ingredient->getAll();
      $inputArray["compo"] = array();
      $input = "";
      $count =   count($ingredients);

      for ($i = 0; $i < $count; $i++) {
        $input .= $ingredients[$i]['ingredient']."
        <input type='text' name='" 
        .$ingredients[$i]['id']."'>
        " .$ingredients[$i]['unit'] ."<br>";  
      } 

    $layout = file_get_contents('layout.php');   
    $blockVhod = $this->blockVhod();      
    $pageCreateRecipe = file_get_contents('view/pageCreateRecipe.php');
    $pageCreateRecipe = str_replace('{{composition}}', $input, $pageCreateRecipe);
    $layout = str_replace('{{vhod}}', $blockVhod, $layout);
    $layout = str_replace('{{content}}', $pageCreateRecipe, $layout);

    echo  $layout;  

    } else {
      
       if ( (!empty($_POST["title"])) && (!empty($_POST["steps"]))
              && (!empty($_FILES)) 
            && ($_FILES['picture']['size'] < 150000) 
            && ($_FILES['picture']['type'] == 'image/jpeg') ) {

          $picture = "images/" . $_FILES['picture']['name'];
          move_uploaded_file($_FILES['picture']['tmp_name'], $picture);

          $recipe = new Recipe();
          $recipe->title = $_POST["title"]; 
          unset($_POST["title"]);
          $recipe->cookId = $_SESSION["id"];
          $recipe->steps = $_POST["steps"];
          unset($_POST["steps"]);
          $recipe->picture = "'".$picture."'"; 

          $id = $recipe->createRecipe();

          if ($id) {
            $composition = new Composition();
            $composition->recipeId = $id;

          foreach ($_POST as $ingredientId => $counts) {
            if (!empty($counts)) {
              $composition->ingredientId = $ingredientId;
              $composition->counts = $counts; 
              $composition->createComposition();
            }    
          }
          header('Location:http://cooking.com/myrecipes');
          }
      }  else {
          header('Location:http://cooking.com/myrecipes/new');
          } 
      } 
    }
   
  public function getRecipesByCook($id) 
  {
    $recipe = new Recipe();
    $recipe->cookId = $id;
    $recipesByCook = $recipe->getRecipesByCook();
    $blockVhod = $this->blockVhod();
    
    $layout = file_get_contents('layout.php');
    $pageMyRecipes = " ";       
       
    $ingredients = "";
    $count = count($recipesByCook);

    for ($i = 0; $i < $count; $i++) {
      $pageMyRecipes .= file_get_contents('view/pageMyRecipes.php');

      $id = $recipesByCook[$i]["recipe"]["id"];
      $pageMyRecipes = str_replace('{{id}}', $id, $pageMyRecipes);

      $title = $recipesByCook[$i]["recipe"]["title"];
      $pageMyRecipes = str_replace('{{title}}', $title, $pageMyRecipes);

      $steps = $recipesByCook[$i]["recipe"]["steps"];
      $pageMyRecipes = str_replace('{{steps}}', $steps, $pageMyRecipes);

      $picture = $recipesByCook[$i]["recipe"]["picture"];
      $picture = substr($picture, 1);
      $picture = "'../".$picture;
      $pageMyRecipes = str_replace('{{picture}}', $picture, $pageMyRecipes);

      $composition = $recipesByCook[$i]["recipe"]["composition"];
     
      for ($j = 0; $j < count($composition); $j++) {
        $ingredients .= $composition[$j]["name"]." ".
        $composition[$j]["counts"]." ". 
        $composition[$j]["unit"]."<br>"; 
      }
     
      $pageMyRecipes = str_replace('{{composition}}', $ingredients, $pageMyRecipes); 
      $ingredients = "";  
      }  
      
    $layout = str_replace('{{vhod}}', $blockVhod, $layout);
    $layout = str_replace('{{content}}', $pageMyRecipes, $layout); 
     
  echo $layout;
  }

  private function blockVhod()
  {
    if ($_SESSION["auth"] == false) { 
      $blockVhod = file_get_contents('view/blockAuth.php');
      return $blockVhod;
    }
    if ($_SESSION["auth"] == true) {
      $blockVhod = file_get_contents('view/blockUser.php'); 
      $blockVhod = str_replace('{{surname}}',
        $_SESSION["surname"], $blockVhod);
      $blockVhod = str_replace('{{name}}',
        $_SESSION["name"], $blockVhod);
      return $blockVhod;
    }
  } 
}
?>