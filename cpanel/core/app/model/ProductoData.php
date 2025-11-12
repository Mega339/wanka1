<?php 
class ProductoData {
    public static $tablename = "producto";

    public $id;
    public $tipomaterial;
    public $negocio;
    public $nombre;
    public $descripcion;
    public $precio_base;
    public $precio_oferta;
    public $stock;
    public $imagen;
    public $modelo;
    public $color;
    public $garantia;
    public $dimensiones;
    public $estado;
    public $codigo;
    public $serie;
    public $talla;
    public $par;
    public $peso;
    public $materiales;
    public $fecha_registro;
    public $total;

    public function registro() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (tipomaterial, negocio, nombre, descripcion, precio_base, precio_oferta, stock, imagen, modelo, color, garantia, dimensiones, estado, codigo, serie, talla, par, peso, materiales, fecha_registro)
                VALUES (:tipomaterial, :negocio, :nombre, :descripcion, :precio_base, :precio_oferta, :stock, :imagen, :modelo, :color, :garantia, :dimensiones, :estado, :codigo, :serie, :talla, :par, :peso, :materiales, NOW())";
        return Executor::doit($sql, [
            ':tipomaterial'  => $this->tipomaterial,
            ':negocio'       => $this->negocio,
            ':nombre'        => $this->nombre,
            ':descripcion'   => $this->descripcion,
            ':precio_base'   => $this->precio_base,
            ':precio_oferta' => $this->precio_oferta,
            ':stock'         => $this->stock,
            ':imagen'        => $this->imagen,
            ':modelo'        => $this->modelo,
            ':color'         => $this->color,
            ':garantia'      => $this->garantia,
            ':dimensiones'   => $this->dimensiones,
            ':estado'        => $this->estado,
            ':codigo'        => $this->codigo,
            ':serie'         => $this->serie,
            ':talla'         => $this->talla,
            ':par'           => $this->par,
            ':peso'          => $this->peso,
            ':materiales'    => $this->materiales
        ]);
    }

    public function actualizar() {
        $campos = [
            "tipomaterial"  => $this->tipomaterial,
            "negocio"       => $this->negocio,
            "nombre"        => $this->nombre,
            "descripcion"   => $this->descripcion,
            "precio_base"   => $this->precio_base,
            "precio_oferta" => $this->precio_oferta,
            "stock"         => $this->stock,
            "imagen"        => $this->imagen,
            "modelo"        => $this->modelo,
            "color"         => $this->color,
            "garantia"      => $this->garantia,
            "dimensiones"   => $this->dimensiones,
            "estado"        => $this->estado,
            "codigo"        => $this->codigo,
            "serie"         => $this->serie,
            "talla"         => $this->talla,
            "par"           => $this->par,
            "peso"          => $this->peso,
            "materiales"    => $this->materiales
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

        $sql = "UPDATE ".self::$tablename." SET ".implode(", ", $fields)." WHERE id = :id";
        return Executor::doit($sql, $params);
    }

    public static function verid($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id = $id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new ProductoData());
    }

    public function eliminar(){
        $sql = "DELETE FROM ".self::$tablename." WHERE id = $this->id";
        Executor::doit($sql);
    }

    public static function duplicidad($nombre){
        $sql = "SELECT * FROM ".self::$tablename." WHERE nombre = '$nombre'";
        $query = Executor::doit($sql);
        return Model::many($query[0], new ProductoData());
    }

    public static function evitarduplicidad($codigo, $id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE nombre = '$nombre' AND id != $id";
        $query = Executor::doit($sql);
        return Model::many($query[0], new ProductoData());
    }

    public static function vercontenido(){
        $sql = "SELECT * FROM ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new ProductoData());
    }

    public static function vercontenidopaginado($start, $length, $search = ''){
        $sql = "SELECT * FROM ".self::$tablename;
        if($search){
            $sql .= " WHERE nombre LIKE '%$search%' OR descripcion LIKE '%$search%' OR modelo LIKE '%$search%'";
        }
        $sql .= " LIMIT $start, $length";
        $query = Executor::doit($sql);
        return Model::many($query[0], new ProductoData());
    }

    public static function totalregistros(){
        $sql = "SELECT COUNT(*) AS total FROM ".self::$tablename;
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new ProductoData());
        return $result->total;
    }

    public static function totalregistrosbuscados($search = ''){
        $sql = "SELECT COUNT(*) AS total FROM ".self::$tablename;
        if($search){
            $sql .= " WHERE nombre LIKE '%$search%' OR descripcion LIKE '%$search%' OR modelo LIKE '%$search%'";
        }
        $query = Executor::doit($sql);
        $result = Model::one($query[0], new ProductoData());
        return $result->total;
    }
}
?>
