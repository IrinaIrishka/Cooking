<?php
spl_autoload_register();

class Ingredient
{
    public $id;
    public $name;
    public $unit;
    public $table='ingredients';

    public function getAll() {
        $sql = "SELECT * FROM $this->table";
        $result = Database::connect()->query($sql);
        $count = $result->num_rows;
        $data = array();
        for ($i = 0; $i < $count; $i++) {
            $row = $result->fetch_array();
            $array = array(
                "id" => $row[0],
                "ingredient" => $row[1],
                "unit" => $row[2]
                ); 
            array_push($data, $array);
        }

    return $data;
    }
}
?>