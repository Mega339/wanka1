<?php 
class ClienteData {
    public static $tablename = "cliente";
    public $id;
    public $negocio ;
    public $nombres;
    public $apellidos;
    public $dni;
    public $telefono;
    public $email;
    public $direccion;
    public $fecha_registro;
    public $total;

    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (negocio, nombres, apellidos, dni, telefono, email, direccion, fecha_registro)
                VALUES (:negocio, :nombres, :apellidos, :dni, :telefono, :email, :direccion, NOW())";
        
        return Executor::doit($sql, [
            ':negocio'        => $this->negocio ?: null,
            ':nombres'        => $this->nombres,
            ':apellidos'      => $this->apellidos,
            ':dni'            => $this->dni,
            ':telefono'       => $this->telefono,
            ':email'          => $this->email,
            ':direccion'      => $this->direccion
        ]);
    }


    
    public function actualizar() {
    $campos = [
        "negocio"        => $this->negocio,
        "nombres"        => $this->nombres,
        "apellidos"      => $this->apellidos,
        "telefono"       => $this->telefono,
        "email"          => $this->email,
        "direccion"      => $this->direccion,
        "fecha_registro" => $this->fecha_registro,
    ];

    $fields = [];
    $params = [":dni" => $this->dni]; // identificador

    foreach ($campos as $columna => $valor) {
        $fields[] = "$columna = :$columna";
        $params[":$columna"] = $valor;
    }

    if (empty($fields)) {
        return false; // No hay campos para actualizar
    }

    $sql = "UPDATE " . self::$tablename . 
           " SET " . implode(", ", $fields) . 
           " WHERE dni = :dni";

    return Executor::doit($sql, $params);
}

    public static function verid($id){
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0],new ClienteData());
    }
    
    public function eliminar(){
        $sql = "delete from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public static function duplicidad($dni){
        $sql = "select * from ".self::$tablename." where dni=$dni";
        $query = Executor::doit($sql);
        return Model::many($query[0],new ClienteData());
    }
    
    public static function evitarduplicidad($dni, $id){
        $sql = "select * from ".self::$tablename." where dni=$dni AND id != $id";
        $query = Executor::doit($sql);
        return Model::many($query[0],new ClienteData());
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new ClienteData());
    }

    public static function vercontenidopaginado($start, $length, $search=''){
        $sql = "select * from ".self::$tablename;
        if($search){
            $sql .= " where nombres like '%$search%' or apellidos like '%$search%' or dni like '%$search%'";
        }
        $sql .= " limit $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0],new ClienteData());
    }

    public static function totalregistros(){
        $sql = "select count(*) as total from ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new ClienteData());
        return $result->total;
    }

    public static function totalregistrosbuscados($search=''){
        $sql = "select count(*) as total from ".self::$tablename;
        if($search){
            $sql .= " where nombres like '%$search%' or apellidos like '%$search%' or dni like '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new ClienteData());
        return $result->total;
    }
    public function Registrodecliente(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new ClienteData());

    }
}
?>