<?php
session_start();

include_once 'controllers/recipeController.php';
include_once 'controllers/authController.php';
include_once 'controllers/cookController.php';

error_reporting(0);

$url  = $_SERVER['REQUEST_URI'];
$urlArr = explode('/', $url);

if (($urlArr[0] == '') && ($urlArr[1] == '')) {
   $recipeController = new RecipeController();
   $recipeController->getAll();  
}  

if (($urlArr[0] == '') && ($urlArr[1] == 'recipe')) {
   $id = $urlArr[2];
   $recipeController = new RecipeController();
   $recipeController->getRecipeById($id);
} 

if (($urlArr[0] == '') && ($urlArr[1] == 'destroy')) {
   $authController = new AuthController();
   $authController->destroy();
} 

if (($urlArr[0] == '') && ($urlArr[1] == 'auth') && ($urlArr[2] == '')) {
   $authController = new AuthController();
   $authController->auth();
}

if (($urlArr[0] == '') && ($urlArr[1] == 'myrecipes') && ($urlArr[2] == '')) {
   $id = $_SESSION["id"];
   $recipeController = new RecipeController();
   $recipeController->getRecipesByCook($id);
} 

if (($urlArr[0] == '') && ($urlArr[1] == 'myrecipes') && ($urlArr[2] == 'new') ) {
   $recipeController = new RecipeController();
   $recipeController->createRecipe();
} 
 
if (($urlArr[0] == '') && ($urlArr[1] == 'auth') && ($urlArr[2] == 'registration')) {
   $cookController = new CookController();
   $cookController->createCook();
}
?>