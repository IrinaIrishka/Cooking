<?php
spl_autoload_register();

class Cook 
{
    public $id;
    public $surname;
    public $name;
    public $login;
    public $password;
    public $table = "cooks";

    public function createCook()
    {
        $sql = "INSERT INTO $this->table (surname, name, 
        login, password) VALUES (?, ?, ?, ?)";

        if ($stmt = Database::connect()->prepare($sql)) {
            $stmt->bind_param("ssss", $this->surname, 
            $this->name, $this->login, $this->password);
            $stmt->execute(); 
    
            $_SESSION["auth"] = true;
            $_SESSION["surname"] = $this->surname;
            $_SESSION["name"] = $this->name;
            header('Location:http://cooking.com');
        } else {
           $_SESSION["auth"] = false;
           header('Location:http://cooking.com');
        }
    }
}
?>