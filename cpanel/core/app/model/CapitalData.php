<?php
class CapitalData
{
    public static $tablename = "capital";

    public $id;
    public $negocio;
    public $monto_inicial;
    public $monto_actual;
    public $descripcion;
    public $responsable;
    public $fecha;
    public $total;

    public function registro()
    {
        $sql = "INSERT INTO " . self::$tablename . " 
        (negocio, monto_inicial, monto_actual, descripcion, responsable, fecha)
        VALUES (:negocio, :monto_inicial, :monto_actual, :descripcion, :responsable, NOW())";

        return Executor::doit($sql, [
            ':negocio' => $this->negocio ?: null,
            ':monto_inicial' => $this->monto_inicial,
            ':monto_actual' => $this->monto_actual,
            ':descripcion' => $this->descripcion,
            ':responsable' => $this->responsable
        ]);
    }

    public function actualizar()
    {
        $sql = "UPDATE " . self::$tablename . " 
                SET negocio = :negocio, monto_inicial = :monto_inicial, 
                    monto_actual = :monto_actual, descripcion = :descripcion, 
                    responsable = :responsable 
                WHERE id = :id";

        return Executor::doit($sql, [
            ':negocio' => $this->negocio,
            ':monto_inicial' => $this->monto_inicial,
            ':monto_actual' => $this->monto_actual,
            ':descripcion' => $this->descripcion,
            ':responsable' => $this->responsable,
            ':id' => $this->id
        ]);
    }

    public static function verid($id)
    {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id = :id";
        $query = Executor::doit($sql, [":id" => $id]);
        return Model::one($query[0], new CapitalData());
    }

    public function eliminar()
    {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = :id";
        return Executor::doit($sql, [':id' => $this->id]);
    }

    public static function duplicidad($descripcion)
    {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE descripcion = :descripcion";
        $query = Executor::doit($sql, [":descripcion" => $descripcion]);
        return Model::one($query[0], new CapitalData());
    }

    public static function vercontenido()
    {
        $sql = "SELECT * FROM " . self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new CapitalData());
    }

    public static function vercontenidopaginado($start, $length, $search = '')
    {
        $sql = "SELECT * FROM " . self::$tablename;
        $params = [];

        if (!empty($search)) {
            $sql .= " WHERE monto_inicial LIKE :search 
                      OR monto_actual LIKE :search 
                      OR responsable LIKE :search";
            $params[':search'] = "%$search%";
        }

        $sql .= " LIMIT " . intval($start) . ", " . intval($length);

        $query = Executor::doit($sql, $params);
        return Model::many($query[0], new CapitalData());
    }

    public static function totalregistros()
    {
        $sql = "SELECT COUNT(*) AS total FROM " . self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new CapitalData());
        return $result ? $result->total : 0;
    }

    public static function totalregistrosbuscados($search = '')
    {
        $sql = "SELECT COUNT(*) AS total FROM " . self::$tablename;
        $params = [];

        if (!empty($search)) {
            $sql .= " WHERE monto_inicial LIKE :search 
                      OR monto_actual LIKE :search 
                      OR responsable LIKE :search";
            $params[':search'] = "%$search%";
        }

        $query = Executor::doit($sql, $params);
        $result = Model::one($query[0], new CapitalData());
        return $result ? $result->total : 0;
    }
}
?>
