<?php
class TipoanuncioData {
    
    public static $tablename = "tipoanuncio";

    public $id;
    public $nombre;
    public $descripcion;
    public $estado;
    public $total;


    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (nombre, descripcion, estado)
                VALUES (:nombre, :descripcion, :estado)";
        return Executor::doit($sql, [
            ':nombre'   => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':estado' => $this->estado
        ]);
    }
    
    public function actualizar(){
        $campos=[
            "nombre"=>$this->nombre,
            "descripcion"=>$this->descripcion,
            "estado"=>$this->estado
        ];
        $fields = [];
        $params = [":id" => $this->id];
        foreach($campos as $columna => $valor){
            if($valor !== null && $valor !== ''){
                $fields[] = "$columna = :$columna";
                $params[":$columna"] = $valor;
            }
        } 
        if(empty($fields)){
            return false; 
        }
        $sql = "UPDATE ".self::$tablename." SET ".implode(", ", $fields)." WHERE id=:id";
        return Executor::doit($sql, $params);
    }

    public function actualizartipoanuncio(){
        $sql = "UPDATE ".self::$tablename." SET nombre='$this->nombre' WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function verid($id){
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0],new TipoanuncioData());
    }

    public function eliminar(){
        $sql = "delete  from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public static function duplicidad($nombre){
        $sql = "SELECT * FROM ".self::$tablename." WHERE nombre = \"$nombre\"";
        $query = Executor::doit($sql);
        return Model::many($query[0], new TipoanuncioData());
    }

    public static function evitarduplicidad($nombre, $id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE nombre = \"$nombre\" AND id != $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], new TipoanuncioData());
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new TipoanuncioData());
    }

    public static function vercontenidopaginado($start, $length, $search=''){
        $sql = "select * from ".self::$tablename;
        if($search){
            $sql .= " where nombre like '%$search%' or descripcion like '%$search%'";
        }
        $sql .= " limit $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0],new TipoanuncioData());
    }

    public static function totalregistros(){
        $sql = "select count(*) as total from ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new TipoanuncioData());
        return $result->total;
    }

    public static function totalregistrosbuscados($search=''){
        $sql = "select count(*) as total from ".self::$tablename;
        if($search){
            $sql .= " where nombre like '%$search%' or descripcion like '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new TipoanuncioData());
        return $result->total;
    }
}
?>