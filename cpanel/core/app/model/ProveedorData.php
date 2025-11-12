<?php 
class ProveedorData {
    public static $tablename = "proveedores";
    public $id;
    public $nombre;
    public $telefono;
    public $email;
    public $direccion;
    public $ciudad;
    public $pais;
    public $ruc;
    public $sitio_web;
    public $estado;
    public $categoria;
    public $condiciones_pago;
    public $moneda_preferida;
    public $calificacion;
    public $fecha_registro;
    public $total;
    
    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (nombre, telefono, email, direccion, ciudad, pais, ruc, sitio_web, estado, 
                 categoria, condiciones_pago, moneda_preferida, calificacion, fecha_registro)
                VALUES (:nombre, :telefono, :email, :direccion, :ciudad, :pais, :ruc, :sitio_web, :estado,
                        :categoria, :condiciones_pago, :moneda_preferida, :calificacion, :fecha_registro)";
        return Executor::doit($sql, [
            ':nombre'            => $this->nombre,
            ':telefono'          => $this->telefono,
            ':email'             => $this->email,
            ':direccion'         => $this->direccion,
            ':ciudad'            => $this->ciudad,
            ':pais'              => $this->pais,
            ':ruc'               => $this->ruc,
            ':sitio_web'         => $this->sitio_web,
            ':estado'            => $this->estado,
            ':categoria'         => $this->categoria,
            ':condiciones_pago'  => $this->condiciones_pago,
            ':moneda_preferida'  => $this->moneda_preferida,
            ':calificacion'      => $this->calificacion,
            ':fecha_registro'    => $this->fecha_registro
        ]);
    }

    public function actualizar(){
        $campos = [
            "nombre"            => $this->nombre,
            "telefono"          => $this->telefono,
            "email"             => $this->email,
            "direccion"         => $this->direccion,
            "ciudad"            => $this->ciudad,
            "pais"              => $this->pais,
            "ruc"               => $this->ruc,
            "sitio_web"         => $this->sitio_web,
            "estado"            => $this->estado,
            "categoria"         => $this->categoria,
            "condiciones_pago"  => $this->condiciones_pago,
            "moneda_preferida"  => $this->moneda_preferida,
            "calificacion"      => $this->calificacion
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
        return Model::one($query[0],new ProveedorData());
    }

    public function eliminar(){
        $sql = "delete from ".self::$tablename." where id=$this->id";
        Executor::doit($sql);
    }

    public static function duplicidad($ruc){
        $sql = "select * from ".self::$tablename." where ruc='$ruc'";
        $query = Executor::doit($sql);
        return Model::many($query[0],new ProveedorData());
    }

    public static function evitarduplicidad($ruc, $id){
        $sql = "select * from ".self::$tablename." where ruc='$ruc' AND id != $id";
        $query = Executor::doit($sql);
        return Model::many($query[0],new ProveedorData());
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new ProveedorData());
    }

    public static function vercontenidopaginado($start, $length, $search=''){
        $sql = "select * from ".self::$tablename;
        if($search){
            $sql .= " where nombre like '%$search%' or ruc like '%$search%' or categoria like '%$search%' or email like '%$search%'";
        }
        $sql .= " order by fecha_registro desc limit $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0],new ProveedorData());
    }

    public static function totalregistros(){
        $sql = "select count(*) as total from ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new ProveedorData());
        return $result->total;
    }

    public static function totalregistrosbuscados($search=''){
        $sql = "select count(*) as total from ".self::$tablename;
        if($search){
            $sql .= " where nombre like '%$search%' or ruc like '%$search%' or categoria like '%$search%' or email like '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0],new ProveedorData());
        return $result->total;
    }
}
?>