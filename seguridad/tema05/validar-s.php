<?php

include "../../seguridad/tema05/funciones.php";
//Recibimos el nombre de usuario
$usuario="";
if (!isset($_POST['usuario'])){
	header("Location: login.php?mensaje=".urlencode("ERROR.\nInroduzca los datos de nuevo."));
	exit;
}
$usuario=strip_tags(trim($_POST['usuario']));


//Recibimos la clave
$clave="";


if (!isset($_POST['clave'])){
	header("Location: login.php?mensaje=".urlencode("ERROR.\nInroduzca los datos de nuevo."));
	exit;
}
$clave=strip_tags(trim($_POST['clave']));






if (empty($usuario) || strlen($usuario)>20 || empty($clave) || strlen($clave)>20){
	header("Location: login.php?mensaje=".urlencode("Usuario inexistente o clave no reconocida"));
	exit;
}


//Nos conectamos con la base de datos para comprobar que el usuario y la clave son correctos
$canal=@mysqli_connect(IP,USUARIO,CLAVE,BD);
if (!$canal){
	echo "Ha ocurrido el error: ".mysqli_connect_errno()." ".mysqli_connect_error()."<br />";
exit;
}
mysqli_set_charset($canal,"utf8");

$sql="select usuario,clave,cuota from usuarios where usuario=?";
$consulta=mysqli_prepare($canal,$sql);
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
exit;	
}
mysqli_stmt_bind_param($consulta,"s",$uusuario);
	
$uusuario=$usuario;


mysqli_stmt_execute($consulta);
mysqli_stmt_bind_result($consulta,$usuarioBD,$claveBD,$cuotaBD);
mysqli_stmt_store_result($consulta);
$n=mysqli_stmt_num_rows($consulta);

//Comprobamos que hay algun usuario que corresponda con el usuario introducido
if ($n!=1){
	header("Location: login.php?mensaje=".urlencode("Usuario inexistente o clave no reconocida"));
	exit;
}

mysqli_stmt_fetch($consulta);
mysqli_stmt_close($consulta);
unset($consulta);




//Comprobamos que la contraseña sea correcta
if (password_verify($clave, $claveBD)){
    
    //Creamos sesion
    session_name("SESION");
    session_cache_limiter('nocache');
    session_start();

    //Datos básicos del usuario (secretos)
    $_SESSION['validado']=true;
    $_SESSION['usuario']=$usuario;
    $_SESSION['cuota']=$cuotaBD;		


    header("Location: hdd.php?mensaje=".urlencode("Login correcto."));
    
    
    
    
}else{
    header("Location: login.php?mensaje=".urlencode("Contraseña erronea"));
}
















?>