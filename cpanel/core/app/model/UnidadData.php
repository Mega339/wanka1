<?php 
class UnidadData {
    public static $tablename = "Unidad";
    public $id;
    public $negocio ;
    public $nombre;
    public $simbolo;
    
    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (negocio, nombre,simbolo)
                VALUES (:negocio,  :nombre, :simbolo)";
        return Executor::doit($sql, [
            ':negocio'  => $this->negocio ?: null,
            ':nombre'   => $this->nombre,
            ':simbolo' => $this->simbolo,
        ]);
    }
    
    public function actualizar(){
        $campos=[
            "negocio"=>$this->negocio,
            "nombre"=>$this->nombre,
            "simbolo"=>$this->simbolo,
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

    public static function verid($id){
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0],new UnidadData());
    }

    public function eliminar(){
        $sql = "delete  from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new UnidadData());
    }

       public static function vercontenidopaginado($start, $length, $search=''){
        $sql = "SELECT * FROM ".self::$tablename;
        if($search){
            $sql .= " WHERE nombre LIKE :search OR simbolo LIKE :search";
        }
        $sql .= " LIMIT :start, :length";

        $params = [
            ":search" => "%$search%",
            ":start" => (int)$start,
            ":length" => (int)$length
        ];

        $query = Executor::doit($sql, $params);
        return Model::many($query[0], new UnidadData());
    }

    public static function totalregistros(){
        $sql = "select count(*) as total from ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new UnidadData());
        return $result->total;
    }

        public static function totalregistrosbuscados($search=''){
        $sql = "SELECT COUNT(*) AS total FROM ".self::$tablename;
        if($search){
            $sql .= " WHERE nombre LIKE :search OR simbolo LIKE :search";
        }
        $query = Executor::doit($sql, [":search" => "%$search%"]);
        $result = Model::one($query[0], new UnidadData());
        return $result->total;
    }
}
?>