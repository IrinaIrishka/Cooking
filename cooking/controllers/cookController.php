<?php
include_once 'model/cook.php';
include_once 'model/auth.php';
include_once 'recipeController.php';

class CookController
{
    public function createCook()
    {
        if (!empty($_POST)) {
            
            if ( (!empty($_POST["surname"])) 
            && (!empty($_POST["name"]) )
            && (!empty($_POST["login"]))
            && (!empty($_POST["password"])) ) {
                $cook = new Cook();
                $cook->surname = $_POST["surname"];
                $cook->name = $_POST["name"];
                $cook->login = $_POST["login"];
                $cook->password = password_hash($_POST["password"], 
                    PASSWORD_DEFAULT);
                $cook->createCook();
            }   
        } else {
            $pageRegistr = file_get_contents("view/pageRegistr.php");
            $layout = file_get_contents("layout.php");
            $layout = str_replace('{{vhod}}', '', $layout);
            $layout =  str_replace('{{content}}', $pageRegistr, $layout);
            echo $layout;
        }
    }
}
?>