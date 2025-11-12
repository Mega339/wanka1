<?php 
class TipomaterialData {
    public static $tablename = "tipomaterial";
    public $id;
    public $negocio;
    public $categoria;
    public $nombre;
    public $descripcion;
    public $total;
    
    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (negocio, categoria, nombre, descripcion)
                VALUES (:negocio, :categoria, :nombre, :descripcion)";
        return Executor::doit($sql, [
            ':negocio'  => $this->negocio ?: null,
            ':categoria'   => $this->categoria ?: null,
            ':nombre'      => $this->nombre,
            ':descripcion' => $this->descripcion,
        ]);
        //ineer join
    }

    public function actualizar(){
        $campos = [
            "negocio"     => $this->negocio,
            "categoria"   => $this->categoria,
            "nombre"      => $this->nombre,
            "descripcion" => $this->descripcion,
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
        return Model::one($query[0],new TipomaterialData());
    }

    public function eliminar(){
        $sql = "delete from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public static function duplicidad($nombre, $negocio){
        $sql = "select * from ".self::$tablename." where nombre='$nombre' AND negocio=$negocio";
        $query = Executor::doit($sql);
        return Model::many($query[0],new TipomaterialData());
    }

    public static function evitarduplicidad($nombre, $negocio, $id){
        $sql = "select * from ".self::$tablename." where nombre='$nombre' AND negocio=$negocio AND id != $id";
        $query = Executor::doit($sql);
        return Model::many($query[0],new TipomaterialData());
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new TipomaterialData());
    }

    public static function vercontenidopaginado($start, $length, $search=''){
    $sql = "SELECT 
                t.id, 
                n.nombre AS negocio, 
                cat.nombre AS categoria, 
                t.nombre, 
                t.descripcion
            FROM ".self::$tablename." t
            INNER JOIN negocio n ON t.negocio = n.id
            INNER JOIN categoria cat ON t.categoria = cat.id";

    if($search){
        $sql .= " WHERE t.nombre LIKE '%$search%' 
                  OR n.nombre LIKE '%$search%' 
                  OR cat.nombre LIKE '%$search%'";
    }

    $sql .= " LIMIT $start, $length";

    $query = Executor::doit($sql);
    return Model::many($query[0], new TipomaterialData());
}


    public static function totalregistros(){
        $sql = "select count(*) as total from ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new TipomaterialData());
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
        $result = Model::one($query[0],new TipomaterialData());
        return $result->total;
    }
}
?>