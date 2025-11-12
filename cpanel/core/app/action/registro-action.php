<?php
$con = Database::getInstance()->getConnection();
$actions = isset($_REQUEST['actions']) ? $_REQUEST['actions'] : null;

if ($actions==1) {
    $existe = UserData::duplicidad($_POST["dni"]);
    if($existe==null){
        $registro = new UserData();
        foreach ($_POST as $k=>$v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->usuario = $registro->dni;
        $registro->password = password_hash($registro->dni, PASSWORD_DEFAULT);
        $registro->estado = 1;
        $registro->registro();
        $_SESSION['registro'] = "Registro Exitoso";
        header("Location: usuario");
    } else {
       $_SESSION['duplicidad'] = "El Registro ya Existe.";
        header("Location: usuario");
    }
}
if($actions==2){
    $actualizar = new UserData();
    foreach ($_POST as $k=>$v)  {
        if(property_exists($actualizar, $k)){
            $actualizar->$k = $v;
        }
    }
    if(UserData::evitarduplicidad($_POST["dni"], $_POST["id"])){
        $_SESSION['duplicidad'] = "El DNI ya Existe.";
        header("Location: usuario");
        exit;
    }
    if($_POST["usuario"]){
        $actualizar->usuario = $_POST["usuario"];
        $actualizar->actualizarusuario();
    }
    if($_POST["password"]){
        $actualizar->password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $actualizar->actualizarpassword();
    }
    $actualizar->estado = isset($_POST["estado"]) ? 1 : 0;
    $actualizar->actualizar();
    $_SESSION['actualizar'] = "Actualización Exitosa";
    header("Location: usuario");
    exit;
}
if($actions==3){
    if($_SESSION['user'] == $_POST['id']){
        $_SESSION['eliminado'] = "No puedes eliminarte a usted mismo.";
    } else{
        try {
            $con->beginTransaction();
            $eliminar = UserData::verid($_POST['id']);
            $eliminar->id = $_POST['id'];
            $eliminar->eliminar();
            $con->commit();
            $_SESSION['eliminado'] = "Eliminado con Exito...!";
        } catch (PDOException $e) {
           $con->rollBack();
           $_SESSION['eliminado'] = "Error al eliminar el registro tiene vinculo con otros registros.";
        }
    }
    header("Location: usuario");
    exit;
}
if ($actions==4) {
    $existe = ClienteData::duplicidad($_POST["dni"]);
    if($existe==null){
        $registro = new ClienteData();
        foreach ($_POST as $k=>$v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->nombres = $_POST["nombre"];
        $registro->apellidos = $_POST["apellido"];
        $registro->registro();
        $_SESSION['registro'] = "Registro Exitoso";
        header("Location: cliente");
    } else {
       $_SESSION['duplicidad'] = "El Registro ya Existe.";
        header("Location: cliente");
    }
}
if($actions==5){
    echo "llego";
    $actualizar = new ClienteData();
    foreach ($_POST as $k=>$v)  {
        if(property_exists($actualizar, $k)){
            $actualizar->$k = $v;
        }
    }
    if(ClienteData::evitarduplicidad($_POST["dni"], $_POST["id"])){
        $_SESSION['duplicidad'] = "El DNI ya Existe.";
        header("Location: cliente");
        exit;
    }
    $actualizar->actualizar();
    $_SESSION['actualizar'] = "Actualización Exitosa";
    header("Location: cliente");
    exit;
}
if($actions==6){
    try {
            $con->beginTransaction();
            $eliminar = ClienteData::verid($_POST['id']);
            $eliminar->id = $_POST['id'];
            $eliminar->eliminar();
            $con->commit();
            $_SESSION['eliminado'] = "Eliminado con Exito...!";
        } catch (PDOException $e) {
           $con->rollBack();
           $_SESSION['eliminado'] = "Error al eliminar el registro tiene vinculo con otros registros.";
        }
    header("Location: cliente");
    exit;
}
if ($actions == 7) {
    $existe = ProveedorData::duplicidad($_POST["ruc"]);
    if($existe == null){
        $registro = new ProveedorData();
        foreach ($_POST as $k => $v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->estado = 1;
        $registro->fecha_registro = date('Y-m-d H:i:s');
        $registro->registro();
        $_SESSION['success_message'] = "Proveedor Registrado Exitosamente";
        header("Location: proveedor");
    } else {
        $_SESSION['error_message'] = "El RUC ya Existe";
        header("Location: proveedor");
    }
}

if ($actions == 8){
    $actualizar = new ProveedorData();
    foreach ($_POST as $k => $v)  {
        if(property_exists($actualizar, $k)){
            $actualizar->$k = $v;
        }
    }
    if (ProveedorData::evitarduplicidad($_POST["ruc"], $_POST["id"])) {
        $_SESSION['error_message'] = "El RUC ya Existe";
        header("Location: proveedor");
        exit;
    }
    $actualizar->estado = isset($_POST['estado']) ? 1 : 0;
    $actualizar->actualizar();
    $_SESSION['success_message'] = "Proveedor Actualizado Exitosamente";
    header("Location: proveedor");
    exit;
}

if ($actions == 9){
    try {
        $con->beginTransaction();
        $eliminar = ProveedorData::verid($_POST['id']);
        $eliminar->id = $_POST['id'];
        $eliminar->eliminar();
        $con->commit();
        $_SESSION['eliminado'] = "Proveedor Eliminado Exitosamente";
    } catch (PDOException $e){
        $con->rollBack();
        $_SESSION['eliminado'] = "Error al eliminar, el proveedor tiene vínculos con otros registros";
    }
    header("Location: proveedor");
    exit;
}
if ($actions == 10) {
    if ($existe == null) {
        $registro = new CapitalData();
        foreach ($_POST as $k => $v) {
            if (property_exists($registro, $k)) {
                $registro->$k = $v;
            }
        }
        $registro->registro();
        $_SESSION['registro'] = "Registro Exitoso";
    } else {
        $_SESSION['duplicidad'] = "El registro ya existe.";
    }
    header("Location: capital");
    exit;
}

if ($actions == 11) {
    $actualizar = new CapitalData();
    foreach ($_POST as $k => $v) {
        if (property_exists($actualizar, $k)) {
            $actualizar->$k = $v;
        }
    }

    $actualizar->actualizar();
    $_SESSION['actualizar'] = "Actualización Exitosa";
    header("Location: capital");
    exit;
}

if ($actions == 12) {
    try {
        $con->beginTransaction();
        $eliminar = CapitalData::verid($_POST['id']);
        $eliminar->id = $_POST['id'];
        $eliminar->eliminar();
        $con->commit();
        $_SESSION['eliminado'] = "Eliminación Exitosa...!";
    } catch (PDOException $e) {
        $con->rollBack();
        $_SESSION['eliminado'] = "Error: El registro tiene vínculos con otros registros.";
    }
    header("Location: capital");
    exit;
}
if ($actions == 13) {
    $existe = MetodoPagoData::duplicidad($_POST["nombre"]);
    if ($existe == null) {
        $registro = new MetodoPagoData();
        foreach ($_POST as $k => $v) {
            if (property_exists($registro, $k)) {
                $registro->$k = $v;
            }
        }
        $registro->registro();
        $_SESSION['registro'] = "Registro Exitoso";
        header("Location: metodopago");
    } else {
        $_SESSION['duplicidad'] = "El Método de Pago ya existe.";
        header("Location: metodopago");
    }
    exit;
}
if ($actions == 14) {
    $actualizar = new MetodoPagoData();
    foreach ($_POST as $k => $v) {
        if (property_exists($actualizar, $k)) {
            $actualizar->$k = $v;
        }
    }

    if (MetodoPagoData::evitarduplicidad($_POST["nombre"], $_POST["id"])) {
        $_SESSION['duplicidad'] = "El nombre ya existe.";
        header("Location: metodopago");
        exit;
    }

    $actualizar->actualizar();
    $_SESSION['actualizar'] = "Actualización Exitosa";
    header("Location: metodopago");
    exit;
}
if ($actions == 15) {
    try {
        $con->beginTransaction();
        $eliminar = MetodoPagoData::verid($_POST['id']);
        $eliminar->id = $_POST['id'];
        $eliminar->eliminar();
        $con->commit();
        $_SESSION['eliminado'] = "Eliminado con exito...!";
    } catch (PDOException $e) {
        $con->rollBack();
        $_SESSION['eliminado'] = "Error al eliminar";
    }

    header("Location: metodopago");
    exit;
}

if ($actions == 16) {
    // Registrar
    $nuevo = new AlmacenData();
    foreach ($_POST as $k => $v) {
        if (property_exists($nuevo, $k)) {
            $nuevo->$k = $v;
        }
    }
    $nuevo->estado = isset($_POST['estado']) ? 'ACTIVO' : 'INACTIVO';
    $nuevo->registro();
    $_SESSION['success_message'] = "Registro exitoso.";
    header("Location: almacen");
    exit;
}

if ($actions == 17) {
    // Actualizar
    $editar = new AlmacenData();
    foreach ($_POST as $k => $v) {
        if (property_exists($editar, $k)) {
            $editar->$k = $v;
        }
    }
    $editar->estado = isset($_POST['estado']) ? 'ACTIVO' : 'INACTIVO';
    $editar->actualizar();
    $_SESSION['success_message'] = "Actualización exitosa.";
    header("Location: almacen");
    exit;
}

if ($actions == 18) {
    // Eliminar
    $eliminar = AlmacenData::verid($_POST['id']);
    $eliminar->id = $_POST['id'];
    $eliminar->eliminar();
    $_SESSION['eliminado'] = "Eliminado correctamente.";
    header("Location: almacen");
    exit;
}
if ($actions==19) {
    $existe = PermisoData::duplicidad($_POST["nombre"]);
    if($existe==null){
        $registro = new PermisoData();
        foreach ($_POST as $k=>$v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->nombre = $_POST["nombre"];
        $registro->descripcion = $_POST["descripcion"];
        $registro->registro();
        $_SESSION['registro'] = "Registro Exitoso";
        header("Location: permiso");
    } else {
       $_SESSION['duplicidad'] = "El Registro ya Existe.";
        header("Location: permiso");
    }
}
if($actions==20){
    echo "llego";
    $actualizar = new PermisoData();
    foreach ($_POST as $k=>$v)  {
        if(property_exists($actualizar, $k)){
            $actualizar->$k = $v;
        }
    }
    if(PermisoData::evitarduplicidad($_POST["nombre"], $_POST["id"])){
        $_SESSION['duplicidad'] = "El Nombre ya Existe.";
        header("Location: permiso");
        exit;
    }
    $actualizar->actualizar();
    $_SESSION['actualizar'] = "Actualización Exitosa";
    header("Location: permiso");
    exit;
}
if($actions==21){
    try {
            $con->beginTransaction();
            $eliminar = PermisoData::verid($_POST['id']);
            $eliminar->id = $_POST['id'];
            $eliminar->eliminar();
            $con->commit();
            $_SESSION['eliminado'] = "Eliminado con Exito...!";
        } catch (PDOException $e) {
           $con->rollBack();
           $_SESSION['eliminado'] = "Error al eliminar el registro tiene vinculo con otros registros.";
        }
    header("Location: permiso");
    exit;
}

if ($actions == 22) {
    $existe = NegocioData::duplicidad($_POST["ruc"]);
    if($existe == null){
        $registro = new NegocioData();
        foreach ($_POST as $k => $v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->estado = 1;
        
        if(isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0){
            $target_dir = "storage/archivo/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                $registro->logo = basename($_FILES["imagen"]["name"]);
            }
        }
        
        $registro->registro();
        $_SESSION['success_message'] = "Negocio Registrado Exitosamente";
        header("Location: negocio");
    } else {
        $_SESSION['error_message'] = "El RUC ya Existe";
        header("Location: negocio");
    }
}
if ($actions == 23){
    $actualizar = new NegocioData();
    foreach ($_POST as $k => $v)  {
        if(property_exists($actualizar, $k)){
            $actualizar->$k = $v;
        }
    }
    if (NegocioData::evitarduplicidad($_POST["ruc"], $_POST["id"])) {
        $_SESSION['error_message'] = "El RUC ya Existe";
        header("Location: negocio");
        exit;
    }
    
    $actualizar->estado = isset($_POST['estado']) ? 1 : 0;
        if(isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0){
        $target_dir = "storage/archivo/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $actualizar->logo = basename($_FILES["imagen"]["name"]);
        }
    } else {
        $actualizar->logo = $_POST['logo_actual'];
    }
    
    $actualizar->actualizar();
    $_SESSION['success_message'] = "Negocio Actualizado Exitosamente";
    header("Location: negocio");
    exit;
}

if ($actions == 24){
    try {
        $con->beginTransaction();
        $eliminar = NegocioData::verid($_POST['id']);
        $eliminar->id = $_POST['id'];
        
        if($eliminar->logo && file_exists("storage/archivo/" . $eliminar->logo)){
            unlink("storage/archivo/" . $eliminar->logo);
        }
        
        $eliminar->eliminar();
        $con->commit();
        $_SESSION['eliminado'] = "Negocio Eliminado Exitosamente";
    } catch (PDOException $e){
        $con->rollBack();
        $_SESSION['eliminado'] = "Error al eliminar, el negocio tiene vínculos con otros registros";
    }
    header("Location: negocio");
    exit;
}
if ($actions == 25) {
    $existe = CategoriaData::duplicidad($_POST["nombre"], $_POST["negocio"]);
    if($existe == null){
        $registro = new CategoriaData();
        foreach ($_POST as $k => $v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->estado = 1;
        $registro->registro();
        $_SESSION['success_message'] = "Categoría Registrada Exitosamente";
        header("Location: categoria");
    } else {
        $_SESSION['error_message'] = "La Categoría ya Existe en este Negocio";
        header("Location: categoria");
    }
}
if ($actions == 26){
    $actualizar = new CategoriaData();
    foreach ($_POST as $k => $v)  {
        if(property_exists($actualizar, $k)){
            $actualizar->$k = $v;
        }
    }
    if (CategoriaData::evitarduplicidad($_POST["nombre"], $_POST["negocio"], $_POST["id"])) {
        $_SESSION['error_message'] = "La Categoría ya Existe en este Negocio";
        header("Location: categoria");
        exit;
    }
    $actualizar->estado = isset($_POST['estado']) ? 1 : 0;
    $actualizar->actualizar();
    $_SESSION['success_message'] = "Categoría Actualizada Exitosamente";
    header("Location: categoria");
    exit;
}
if ($actions == 27){
    try {
        $con->beginTransaction();
        $eliminar = CategoriaData::verid($_POST['id']);
        $eliminar->id = $_POST['id'];
        $eliminar->eliminar();
        $con->commit();
        $_SESSION['eliminado'] = "Categoría Eliminada Exitosamente";
    } catch (PDOException $e){
        $con->rollBack();
        $_SESSION['eliminado'] = "Error al eliminar, la categoría tiene vínculos con otros registros";
    }
    header("Location: categoria");
    exit;
}
if ($actions == 28) {
    $existe = TipomaterialData::duplicidad($_POST["nombre"], $_POST["negocio"]);
    if($existe == null){
        $registro = new TipomaterialData();
        foreach ($_POST as $k => $v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->registro();
        $_SESSION['success_message'] = "Categoría Registrada Exitosamente";
        header("Location: tipomaterial");
    } else {
        $_SESSION['error_message'] = "La Categoría ya Existe en este Negocio";
        header("Location: tipomaterial");
    }
}
if ($actions == 29){
    $actualizar = new TipomaterialData();
    foreach ($_POST as $k => $v)  {
        if(property_exists($actualizar, $k)){
            $actualizar->$k = $v;
        }
    }
    if (TipomaterialData::evitarduplicidad($_POST["nombre"], $_POST["negocio"], $_POST["id"])) {
        $_SESSION['error_message'] = "La Categoría ya Existe en este Negocio";
        header("Location: tipomaterial");
        exit;
    }
    $actualizar->actualizar();
    $_SESSION['success_message'] = "Categoría Actualizada Exitosamente";
    header("Location: tipomaterial");
    exit;
}
if ($actions == 30){
    try {
        $con->beginTransaction();
        $eliminar = TipomaterialData::verid($_POST['id']);
        $eliminar->id = $_POST['id'];
        $eliminar->eliminar();
        $con->commit();
        $_SESSION['eliminado'] = "Categoría Eliminada Exitosamente";
    } catch (PDOException $e){
        $con->rollBack();
        $_SESSION['eliminado'] = "Error al eliminar, la categoría tiene vínculos con otros registros";
    }
    header("Location: tipomaterial");
    exit;
}
if ($actions == 31) {
    $existe = ProductoData::duplicidad($_POST["nombre"]);
    if($existe == null){
        $registro = new ProductoData();
        foreach ($_POST as $k => $v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->estado = 1;
        
        if(isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0){
            $target_dir = "storage/archivo/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                $registro->imagen = basename($_FILES["imagen"]["name"]);
            }
        }
        
        $registro->registro();
        $_SESSION['success_message'] = "Negocio Registrado Exitosamente";
        header("Location: producto");
    } else {
        $_SESSION['error_message'] = "El RUC ya Existe";
        header("Location: producto");
    }
}

            

if ($actions == 32) {
    $actualizar = new ProductoData();

    foreach ($_POST as $k => $v) {
        if (property_exists($actualizar, $k)) {
            $actualizar->$k = $v;
        }
    }

    if (ProductoData::evitarduplicidad($_POST["nombre"], $_POST["id"])) {
        $_SESSION['error_message'] = "El nombre del producto ya existe";
        header("Location: producto");
        exit;
    }

    $actualizar->estado = isset($_POST['estado']) ? 1 : 0;

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $target_dir = "storage/archivo/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $actualizar->imagen = basename($_FILES["imagen"]["name"]);
        }
    } else {
        $actualizar->imagen = $_POST['imagen'];
    }

    $actualizar->actualizar();
    $_SESSION['success_message'] = "Producto actualizado exitosamente";
    header("Location: producto");
    exit;
}

if ($actions == 33) {
    try {
        $con->beginTransaction();
        $eliminar = ProductoData::verid($_POST['id']);
        $eliminar->id = $_POST['id'];

        if ($eliminar->imagen && file_exists("storage/archivo/" . $eliminar->imagen)) {
            unlink("storage/archivo/" . $eliminar->imagen);
        }

        $eliminar->eliminar();
        $con->commit();

        $_SESSION['success_message'] = "Producto eliminado exitosamente";
    } catch (PDOException $e) {
        $con->rollBack();
        $_SESSION['error_message'] = "Error al eliminar el producto. Está vinculado a otros registros.";
    }

    header("Location: producto");
    exit;
}
if ($actions==34) {
    $existe = TipoanuncioData::duplicidad($_POST["nombre"]);
    if($existe==null){
        $registro = new TipoanuncioData();
        foreach ($_POST as $k=>$v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->nombre = $_POST["nombre"];
        $registro->estado = 1;
        $registro->registro();
        $_SESSION['registro'] = "Registro Exitoso";
        header("Location: tipoanuncio");
    } else {
       $_SESSION['duplicidad'] = "El Registro ya Existe.";
        header("Location: tipoanuncio");
    }
}
if($actions==35){
    echo "llego";
    $actualizar = new TipoanuncioData();
    foreach ($_POST as $k=>$v)  {
        if(property_exists($actualizar, $k)){
            $actualizar->$k = $v;
        }
    }
    if(TipoanuncioData::evitarduplicidad($_POST["nombre"], $_POST["id"])){
        $_SESSION['duplicidad'] = "El Nombre ya Existe.";
        header("Location: tipoanuncio");
        exit;
    }
    $actualizar->estado = isset($_POST["estado"]) ? 1 : 0;
    $actualizar->actualizar();
    $_SESSION['actualizar'] = "Actualización Exitosa";
    header("Location: tipoanuncio");
    exit;
}
if($actions==36){
    try {
            $con->beginTransaction();
            $eliminar = TipoanuncioData::verid($_POST['id']);
            $eliminar->id = $_POST['id'];
            $eliminar->eliminar();
            $con->commit();
            $_SESSION['eliminado'] = "Eliminado con Exito...!";
        } catch (PDOException $e) {
           $con->rollBack();
           $_SESSION['eliminado'] = "Error al eliminar el registro tiene vinculo con otros registros.";
        }
    header("Location: tipoanuncio");
    exit;
}
if ($actions==37) {
    $existe = NosotrosData::duplicidad($_POST["titulo"]);
    if($existe==null){
        $registro = new NosotrosData();
        foreach ($_POST as $k=>$v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->registro();
        $_SESSION['registro'] = "Registro Exitoso";
        header("Location: nosotros");
    } else {
       $_SESSION['duplicidad'] = "El Registro ya Existe.";
        header("Location: nosotros");
    }
}
if($actions==38){
    echo "llego";
    $actualizar = new NosotrosData();
    foreach ($_POST as $k=>$v)  {
        if(property_exists($actualizar, $k)){
            $actualizar->$k = $v;
        }
    }
    if(NosotrosData::evitarduplicidad($_POST["nombre"], $_POST["id"])){
        $_SESSION['duplicidad'] = "El Nombre ya Existe.";
        header("Location: nosotros");
        exit;
    }
    $actualizar->actualizar();
    $_SESSION['actualizar'] = "Actualización Exitosa";
    header("Location: nosotros");
    exit;
}
if($actions==39){
    try {
            $con->beginTransaction();
            $eliminar = NosotrosData::verid($_POST['id']);
            $eliminar->id = $_POST['id'];
            $eliminar->eliminar();
            $con->commit();
            $_SESSION['eliminado'] = "Eliminado con Exito...!";
        } catch (PDOException $e) {
           $con->rollBack();
           $_SESSION['eliminado'] = "Error al eliminar el registro tiene vinculo con otros registros.";
        }
    header("Location: nosotros ");
    exit;
}
if ($actions==40)
{
    $existe = MarcaData::duplicidad($_POST["nombre"]);
    if($existe==null){
        $registro = new MarcaData();
        foreach ($_POST as $k=>$v)  {
            if(property_exists($registro, $k)){
                $registro->$k = $v;
            }
        }
        $registro->add();
        $_SESSION['registro'] = "Registro Exitoso";
        header("Location: marca");
    } else {
       $_SESSION['duplicidad'] = "El Registro ya Existe.";
        header("Location: marca");
    }
}
?>