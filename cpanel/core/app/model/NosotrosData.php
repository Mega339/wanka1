<?php 
class NosotrosData {
    public static $tablename = "nosotros";
    public $id;
    public $titulo;
    public $descripcion;
    public $mision;
    public $vision;
    public $valores;
    public $imagen_portada;
    public $total;

    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (titulo, descripcion, mision, vision, valores, imagen_portada)
                VALUES (:titulo, :descripcion, :mision, :vision, :valores, :imagen_portada)";
        return Executor::doit($sql, [
            ':titulo'          => $this->titulo,
            ':descripcion'     => $this->descripcion,
            ':mision'          => $this->mision,
            ':vision'          => $this->vision,
            ':valores'         => $this->valores,
            ':imagen_portada'  => $this->imagen_portada
        ]);
    }

    public function actualizar(){
        $campos = [
            "titulo"          => $this->titulo,
            "descripcion"     => $this->descripcion,
            "mision"          => $this->mision,
            "vision"          => $this->vision,
            "valores"         => $this->valores,
            "imagen_portada"  => $this->imagen_portada
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
        return Model::one($query[0],new NosotrosData());
    }

    public function eliminar(){
        $sql = "delete from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public static function duplicidad($titulo){
        $sql = "select * from ".self::$tablename." where titulo='$titulo'";
        $query = Executor::doit($sql);
        return Model::many($query[0],new NosotrosData());
    }

    public static function evitarduplicidad($titulo, $id){
        $sql = "select * from ".self::$tablename." where titulo='$titulo' AND id != $id";
        $query = Executor::doit($sql);
        return Model::many($query[0],new NosotrosData());
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new NosotrosData());
    }

    public static function vercontenidopaginado($start, $length, $search=''){
        $sql = "select * from ".self::$tablename;
        if($search){
            $sql .= " where titulo like '%$search%' or descripcion like '%$search%' or mision like '%$search%'";
        }
        $sql .= " limit $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0],new NosotrosData());
    }

    public static function totalregistros(){
        $sql = "select count(*) as total from ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new NosotrosData());
        return $result->total;
    }

    public static function totalregistrosbuscados($search=''){
        $sql = "select count(*) as total from ".self::$tablename;
        if($search){
            $sql .= " where titulo like '%$search%' or descripcion like '%$search%' or mision like '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new NosotrosData());
        return $result->total;
    }
}
?>