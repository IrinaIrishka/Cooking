<?php
include_once 'model/Auth.php';

class AuthController
{
  public function auth()
  {
    if (empty($_POST)) {
      $pageAuth = file_get_contents('view/pageAuth.php');
      $layout = file_get_contents('layout.php');
      $layout = str_replace('{{content}}', $pageAuth, $layout);
      $layout = str_replace('{{vhod}}', "", $layout);
      echo $layout;
      exit();
    } else {
        $auth = new Auth();
        $auth->login = $_POST["login"];
        $auth->password = $_POST["password"];
        $auth->auth();
        header('Location:http://cooking.com');
      }
  }

  public function destroy()
  {
    session_destroy();
    header('Location:http://cooking.com');
  }

  public function blockVhod()
  {
    if ($_SESSION["auth"] == false) { 
      $block = file_get_contents('view/blockVhod.php');
      return $block;
    }

    if ($_SESSION["auth"] == true) {
      $block = file_get_contents('view/blockAuth.php'); 
      $block = str_replace('{{surname}}',
      $_SESSION["surname"], $block);
      $block = str_replace('{{name}}',
      $_SESSION["name"], $block);
      return $block;
    }
  } 
}
?>