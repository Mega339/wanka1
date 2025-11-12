<?php 
class NegocioData {
    public static $tablename = "negocio";
    public $id;
    public $nombre;
    public $direccion;
    public $representante;
    public $logo;
    public $ruc;
    public $correo;
    public $telefono;
    public $estado;
    public $total;

    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (nombre, direccion, representante, logo, ruc, correo, telefono, estado)
                VALUES (:nombre, :direccion, :representante, :logo, :ruc, :correo, :telefono, :estado)";
        return Executor::doit($sql, [
            ':nombre'        => $this->nombre,
            ':direccion'     => $this->direccion,
            ':representante' => $this->representante,
            ':logo'          => $this->logo,
            ':ruc'           => $this->ruc,
            ':correo'        => $this->correo,
            ':telefono'      => $this->telefono,
            ':estado'        => $this->estado
        ]);
    }

    public function actualizar(){
        $campos = [
            "nombre"        => $this->nombre,
            "direccion"     => $this->direccion,
            "representante" => $this->representante,
            "logo"          => $this->logo,
            "ruc"           => $this->ruc,
            "correo"        => $this->correo,
            "telefono"      => $this->telefono,
            "estado"        => $this->estado
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
        return Model::one($query[0],new NegocioData());
    }

    public function eliminar(){
        $sql = "delete from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public static function duplicidad($ruc){
        $sql = "select * from ".self::$tablename." where ruc='$ruc'";
        $query = Executor::doit($sql);
        return Model::many($query[0],new NegocioData());
    }

    public static function evitarduplicidad($ruc, $id){
        $sql = "select * from ".self::$tablename." where ruc='$ruc' AND id != $id";
        $query = Executor::doit($sql);
        return Model::many($query[0],new NegocioData());
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new NegocioData());
    }

    public static function vercontenidopaginado($start, $length, $search=''){
        $sql = "select * from ".self::$tablename;
        if($search){
            $sql .= " where nombre like '%$search%' or ruc like '%$search%' or representante like '%$search%'";
        }
        $sql .= " limit $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0],new NegocioData());
    }

    public static function totalregistros(){
        $sql = "select count(*) as total from ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new NegocioData());
        return $result->total;
    }

    public static function totalregistrosbuscados($search=''){
        $sql = "select count(*) as total from ".self::$tablename;
        if($search){
            $sql .= " where nombre like '%$search%' or ruc like '%$search%' or representante like '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new NegocioData());
        return $result->total;
    }
}

?>  