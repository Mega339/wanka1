<?php 
class AlmacenData {
    public static $tablename = "almacen";

    public $id;
    public $nombre;
    public $ubicacion;
    public $telefono;
    public $email;
    public $estado; 
    public $capacidad;
    public $tipo_almacen;
    public $observaciones;
    public $fecha;
    public $total;
    
    // 🔹 Registrar un nuevo almacén
    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (nombre, ubicacion, telefono, email, estado, capacidad, tipo_almacen, observaciones, fecha)
                VALUES (:nombre, :ubicacion, :telefono, :email, :estado, :capacidad, :tipo_almacen, :observaciones, :fecha)";
        return Executor::doit($sql, [
            ':nombre'        => $this->nombre,
            ':ubicacion'     => $this->ubicacion,
            ':telefono'      => $this->telefono,
            ':email'         => $this->email,
            ':estado'        => $this->estado, // ✅ corregido
            ':capacidad'     => $this->capacidad,
            ':tipo_almacen'  => $this->tipo_almacen,
            ':observaciones' => $this->observaciones,
            ':fecha'         => $this->fecha,
        ]);
    }
    
    // 🔹 Actualizar un almacén
    public function actualizar(){
        $campos = [
            "nombre"        => $this->nombre,
            "ubicacion"     => $this->ubicacion,
            "telefono"      => $this->telefono,
            "email"         => $this->email,
            "estado"        => $this->estado, // ✅ corregido
            "capacidad"     => $this->capacidad,
            "tipo_almacen"  => $this->tipo_almacen,
            "observaciones" => $this->observaciones,
            "fecha"         => $this->fecha,
        ];

        $fields = [];
        $params = [":id" => $this->id];
        foreach ($campos as $columna => $valor) {
            if ($valor !== null && $valor !== '') {
                $fields[] = "$columna = :$columna";
                $params[":$columna"] = $valor;
            }
        } 
        if (empty($fields)) return false; 

        $sql = "UPDATE ".self::$tablename." SET ".implode(", ", $fields)." WHERE id=:id";
        return Executor::doit($sql, $params);
    }

    // 🔹 Ver un registro por ID
    public static function verid($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new AlmacenData());
    }

    // 🔹 Eliminar un registro
    public function eliminar(){
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$this->id";
        Executor::doit($sql);
    }

    // 🔹 Verificar duplicidad por nombre
    public static function duplicidad($nombre){
        $sql = "SELECT * FROM ".self::$tablename." WHERE nombre='$nombre'";
        $query = Executor::doit($sql);
        return Model::many($query[0], new AlmacenData());
    }

    // 🔹 Verificar duplicidad al actualizar
    public static function evitarduplicidad($nombre, $id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE nombre='$nombre' AND id!=$id";
        $query = Executor::doit($sql);
        return Model::many($query[0], new AlmacenData());
    }

    // 🔹 Ver todos los registros
    public static function vercontenido(){
        $sql = "SELECT * FROM ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new AlmacenData());
    }

    // 🔹 Ver registros paginados
    public static function vercontenidopaginado($start, $length, $search=''){
        $sql = "SELECT * FROM ".self::$tablename;
        if($search){
            $sql .= " WHERE nombre LIKE '%$search%' OR tipo_almacen LIKE '%$search%' OR ubicacion LIKE '%$search%'";
        }
        $sql .= " LIMIT $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0], new AlmacenData());
    }

    // 🔹 Total de registros
    public static function totalregistros(){
        $sql = "SELECT COUNT(*) AS total FROM ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new AlmacenData());
        return $result->total;
    }

    // 🔹 Total de registros buscados
    public static function totalregistrosbuscados($search=''){
        $sql = "SELECT COUNT(*) AS total FROM ".self::$tablename;
        if($search){
            $sql .= " WHERE nombre LIKE '%$search%' OR tipo_almacen LIKE '%$search%' OR ubicacion LIKE '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new AlmacenData());
        return $result->total;
    }
}
?>