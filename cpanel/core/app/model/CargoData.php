<?php 
class CargoData {
    public static $tablename = "cargos";
    public $id;
    public $nombre ;
    public $estado ;

    public static function verid($id){
        $sql = "select * from ".self::$tablename." where id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0],new CargoData());
    }

    public static function vercontenido(){
        $sql = "select * from ".self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0],new CargoData());
    }
}
?>