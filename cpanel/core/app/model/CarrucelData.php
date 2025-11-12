<?php 
class CarrucelData {
    public static $tablename = "carrucel";

    public $id;
    public $negocio;
    public $titulo;
    public $descripcion;
    public $estado;
    public $imagen;
    public $orden;
    public $visible;
    public $total;


    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (negocio, titulo, descripcion, estado, imagen, orden, visible)
                VALUES (:negocio, :titulo, :descripcion, :estado, :imagen, :orden, :visible)";
        return Executor::doit($sql, [
            ':negocio'     => $this->negocio,
            ':titulo'      => $this->titulo,
            ':descripcion' => $this->descripcion,
            ':estado'      => $this->estado,
            ':imagen'      => $this->imagen,
            ':orden'       => $this->orden,
            ':visible'     => $this->visible
        ]);
    }


    public function actualizar() {
        $campos = [
            "negocio"     => $this->negocio,
            "titulo"      => $this->titulo,
            "descripcion" => $this->descripcion,
            "estado"      => $this->estado,
            "imagen"      => $this->imagen,
            "orden"       => $this->orden,
            "visible"     => $this->visible
        ];

        $fields = [];
        $params = [":id" => $this->id];
        foreach ($campos as $columna => $valor) {
            $fields[] = "$columna=:$columna";
            $params[":$columna"] = $valor;
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE " . self::$tablename . " SET " . implode(", ", $fields) . " WHERE id=:id";
        return Executor::doit($sql, $params);
    }

    /* =====================
       VER POR ID
       ===================== */
    public static function verid($id) {
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new CarrucelData());
    }

    /* =====================
       ELIMINAR
       ===================== */
    public function eliminar() {
        $sql = "DELETE FROM ".self::$tablename." WHERE id=$this->id";
        Executor::doit($sql);
    }

    /* =====================
       COMPROBAR DUPLICIDAD
       ===================== */
    public static function duplicidad($titulo, $negocio) {
        $sql = "SELECT * FROM ".self::$tablename." WHERE titulo='$titulo' AND negocio=$negocio";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CarrucelData());
    }

    public static function evitarduplicidad($titulo, $negocio, $id) {
        $sql = "SELECT * FROM ".self::$tablename." WHERE titulo='$titulo' AND negocio=$negocio AND id != $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CarrucelData());
    }


    public static function vercontenido() {
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY orden ASC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CarrucelData());
    }


    public static function vercontenidopaginado($start, $length, $search='') {
        $sql = "SELECT c.id, n.nombre as negocio, c.titulo, c.descripcion, c.estado, c.imagen, c.orden, c.visible 
                FROM ".self::$tablename." c 
                INNER JOIN negocio n ON c.negocio = n.id";
        if ($search) {
            $sql .= " WHERE c.titulo LIKE '%$search%' OR n.nombre LIKE '%$search%'";
        }
        $sql .= " ORDER BY c.orden ASC LIMIT $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CarrucelData());
    }


    public static function totalregistros() {
        $sql = "SELECT count(*) as total FROM ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new CarrucelData());
        return $result->total;
    }

    public static function totalregistrosbuscados($search='') {
        $sql = "SELECT count(*) as total 
                FROM ".self::$tablename." c 
                INNER JOIN negocio n ON c.negocio = n.id";
        if ($search) {
            $sql .= " WHERE c.titulo LIKE '%$search%' OR n.nombre LIKE '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new CarrucelData());
        return $result->total;
    }


    public static function verCarrucel() {
        $sql = "SELECT id, titulo, descripcion, imagen 
                FROM ".self::$tablename." 
                WHERE visible = 1 AND estado = 1 
                ORDER BY orden ASC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CarrucelData());
    }

    public static function getAll() {
        $sql = "SELECT * FROM " . self::$tablename . " ORDER BY orden ASC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new CarrucelData());
    }
}
?>
