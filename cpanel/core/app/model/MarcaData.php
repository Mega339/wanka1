<?php 
class MarcaData {
    public static $tablename = "marca";

    public $id;
    public $negocio;
    public $nombre;
    public $descripcion;
    public $total;


    public function add() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (negocio, nombre, descripcion)
                VALUES (:negocio, :nombre, :descripcion)";
        return Executor::doit($sql, [
            ':negocio'     => $this->negocio ?: null,
            ':nombre'      => $this->nombre,
            ':descripcion' => $this->descripcion
        ]);
    }

    public function update() {
        $sql = "UPDATE " . self::$tablename . " 
                SET negocio = :negocio, nombre = :nombre, descripcion = :descripcion 
                WHERE id = :id";
        return Executor::doit($sql, [
            ':negocio'     => $this->negocio,
            ':nombre'      => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':id'          => $this->id
        ]);
    }

 
    public function del() {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = :id";
        return Executor::doit($sql, [':id' => $this->id]);
    }
    



    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id = :id";
        $query = Executor::doit($sql, [':id' => $id]);
        return Model::one($query[0], new MarcaData());
    }


    public static function getAll() {
        $sql = "SELECT * FROM " . self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new MarcaData());
    }

 
    public static function duplicidad($nombre) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE nombre = :nombre";
        $query = Executor::doit($sql, [':nombre' => $nombre]);
        $data = Model::many($query[0], new MarcaData());
        return count($data) > 0; 
    }

    public static function evitarduplicidad($nombre, $id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE nombre = :nombre AND id != :id";
        $query = Executor::doit($sql, [':nombre' => $nombre, ':id' => $id]);
        $data = Model::many($query[0], new MarcaData());
        return count($data) > 0;
    }
}

?>
