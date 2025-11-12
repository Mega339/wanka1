<?php
// session_start();
if(isset($_POST['usuario']) && isset($_POST['password'])){
    $user_var = $_POST['usuario'];
    $pass_var = $_POST['password'];

$sql = "SELECT id, password, email FROM usuario WHERE usuario = :usuario AND  estado = 1 ";
$param = [':usuario' => $user_var];

$result = Executor::doit($sql, $param);
if($result[0]->rowCount()==1){
    $row = $result[0]->fetch(PDO::FETCH_ASSOC);

    if(password_verify($pass_var, $row['password'])){
        $_SESSION['user'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        header("Location: ./");
        exit;
    } else {
        $_SESSION['error_data']="contraseña incorrecta";
        header("Location: ./");
        exit;
    }
} else {
        $_SESSION['error_data']="contraseña incorrecta";
        header("Location: ./");
        exit;
    }
}  else {
 header("Location: ./");
    exit;
}
?>