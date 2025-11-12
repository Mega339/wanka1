<?php 
class CategoriaData {
    public static $tablename = "categoria";
    public $id;
    public $negocio;
    public $nombre;
    public $descripcion;
    public $estado;
    public $total;
    
    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (negocio, nombre, descripcion, estado)
                VALUES (:negocio, :nombre, :descripcion, :estado)";
        return Executor::doit($sql, [
            ':negocio'     => $this->negocio,
            ':nombre'      => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':estado'      => $this->estado
        ]);
    }

    public function actualizar(){
        $campos = [
            "negocio"     => $this->negocio,
            "nombre"      => $this->nombre,
            "descripcion" => $this->descripcion,
            "estado"      => $this->estado
        ];
        $fields = [];
        $params = [":id" => $this->id];
        foreach ($campos as $columna => $valor) {
            $fields[] = "$columna=:$columna";
            $params[":$columna"] = $valor;
        }
        if(empty($fields)){
            return false;
        }
        $sql = "UPDATE " . self::$tablename . " SET " . implode(", ", $fields) . " WHERE id=:id";
        return Executor::doit($sql, $params);
    }

    public static function verid($id){
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0],new CategoriaData());
    }

    public function eliminar(){
        $sql = "delete from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public static function duplicidad($nombre, $negocio){
        $sql = "select * from ".self::$tablename." where nombre='$nombre' AND negocio=$negocio";
        $query = Executor::doit($sql);
        return Model::many($query[0],new CategoriaData());
    }

    public static function evitarduplicidad($nombre, $negocio, $id){
        $sql = "select * from ".self::$tablename." where nombre='$nombre' AND negocio=$negocio AND id != $id";
        $query = Executor::doit($sql);
        return Model::many($query[0],new CategoriaData());
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new CategoriaData());
    }

    public static function vercontenidopaginado($start, $length, $search=''){
        $sql = "SELECT c.id, n.nombre as negocio, c.nombre, c.descripcion, c.estado 
                FROM ".self::$tablename." c 
                INNER JOIN negocio n ON c.negocio = n.id";
        if($search){
            $sql .= " WHERE c.nombre LIKE '%$search%' OR n.nombre LIKE '%$search%'";
        }
        $sql .= " LIMIT $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0],new CategoriaData());
    }

    public static function totalregistros(){
        $sql = "select count(*) as total from ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new CategoriaData());
        return $result->total;
    }

    public static function totalregistrosbuscados($search=''){
        $sql = "SELECT count(*) as total 
                FROM ".self::$tablename." c 
                INNER JOIN negocio n ON c.negocio = n.id";
        if($search){
            $sql .= " WHERE c.nombre LIKE '%$search%' OR n.nombre LIKE '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new CategoriaData());
        return $result->total;
    }
}
?>