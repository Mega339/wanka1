<?php 
class MetodoPagoData {
    public static $tablename = "metodopago";

    public $id;
    public $nombre;
    public $total;

    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " (nombre) VALUES (:nombre)";
        return Executor::doit($sql, [':nombre' => $this->nombre]);
    }

    
    public function actualizar() {
        $sql = "UPDATE " . self::$tablename . " SET nombre = :nombre WHERE id = :id";
        return Executor::doit($sql, [':nombre' => $this->nombre, ':id' => $this->id]);
    }

 
    public function eliminar() {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = :id";
        return Executor::doit($sql, [':id' => $this->id]);
    }

 
    public static function verid($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new MetodoPagoData());
    }

  
    public static function vercontenido() {
        $sql = "SELECT * FROM " . self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new MetodoPagoData());
    }

    public static function vercontenidopaginado($start, $length, $search = '') {
        $sql = "SELECT * FROM " . self::$tablename;
        if (!empty($search)) {
            $sql .= " WHERE nombre LIKE '%$search%'";
        }
        $sql .= " LIMIT $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0], new MetodoPagoData());
    }

   
    public static function totalregistros() {
        $sql = "SELECT COUNT(*) AS total FROM " . self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new MetodoPagoData());
        return $result->total;
    }

   
    public static function totalregistrosbuscados($search = '') {
        $sql = "SELECT COUNT(*) AS total FROM " . self::$tablename;
        if (!empty($search)) {
            $sql .= " WHERE nombre LIKE '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new MetodoPagoData());
        return $result->total;
    }


    public static function duplicidad($nombre) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE nombre = '$nombre'";
        $query = Executor::doit($sql);
        return Model::many($query[0], new MetodoPagoData());
    }

    
    public static function evitarduplicidad($nombre, $id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE nombre = '$nombre' AND id != '$id'";
        $query = Executor::doit($sql);
        return Model::many($query[0], new MetodoPagoData());
    }
}
?>
