<?php
spl_autoload_register();

class Auth
{
    public $login;
    public $password;
    public $table = 'cooks';

    public function auth()
    {
        $sql = "SELECT * FROM $this->table 
        WHERE login  = '$this->login'";
      
        $result = Database::connect()->query($sql);
        $count = $result->num_rows;

        if ($count != 0) {
            $row = $result->fetch_array();
            
            if (password_verify($this->password, $row[4])) {
                $_SESSION["auth"] = true;
                $_SESSION["id"] = $row[0];
                $_SESSION["surname"] = $row[1];
                $_SESSION["name"] = $row[2];
            }
        } 
        else {
            $_SESSION["auth"] = false;
        }
    }
}
?>