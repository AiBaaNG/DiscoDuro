<?php
include "../../seguridad/tema05/funciones.php";
include "../../seguridad/tema05/menu-s.php";
require_once("../../seguridad/tema05/sesionesbd.php");
define("__ALMACEN__","../../seguridad/tema05/archivos/");
 
if(!isset($_POST['usuarioH'])){
    header("Location: hdd.php");
	exit;
}

$usuarioH = strip_tags(trim($_POST["usuarioH"]));

if (!isset($_FILES['ficheros'])){
	header("Location: hdd.php");
	exit;
}
if (!is_array($_FILES['ficheros']['name'])){
	header("Location: hdd.php");
	exit;
}


//Comprobamos el espacio disponible del usuario para que no pueda subir archivos mayores
    
$espacioUsado = 0;
$canal=@mysqli_connect(IP,USUARIO,CLAVE,BD);
if (!$canal){
	echo "Ha ocurrido el error: ".mysqli_connect_errno()." ".mysqli_connect_error()."<br />";
exit;
}
mysqli_set_charset($canal,"utf8");

$sql="select tamanyo from ficheros where usuario=?";
$consulta=mysqli_prepare($canal,$sql);
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
exit;	
}
mysqli_stmt_bind_param($consulta,"s",$uusuario);
$uusuario=$usuario;
mysqli_stmt_execute($consulta);
mysqli_stmt_bind_result($consulta,$tamanyoBD);
while(mysqli_stmt_fetch($consulta)){
	$espacioUsado = $espacioUsado + $tamanyoBD;
	
}
$espacioDisponible = 0;
$espacioDisponible = $cuota - $espacioUsado;


mysqli_stmt_close($consulta);
unset($consulta);
                

   




$numeroFicherosSubidos=count($_FILES['ficheros']['name']);
$canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);


if (mysqli_connect_errno()) {
    printf("Error de conexión: %s\n", mysqli_connect_error());
    exit();
}
$sql="insert into ficheros (id,nombre,tamanyo,tipo,usuario) values (?,?,?,?,?);";
$consulta=mysqli_prepare($canal,$sql);
mysqli_stmt_bind_param($consulta,"ssiss",$id_,$nombre_,$tamanyo_,$tipo_,$usuario_);
$mensaje="";
for($i=0;$i<$numeroFicherosSubidos;$i++){
	switch ($_FILES['ficheros']['error'][$i]) {
        case UPLOAD_ERR_OK:
			$id_=uniqid('',true);
			// echo "bbbbbbb $i<br/>";
			$ficheroSubido = __ALMACEN__.$id_;
			if($espacioDisponible<$_FILES['ficheros']['size'][$i]){
				header("Location: hdd.php?mensaje=".urlencode("El archivo no ha podido ser subido porque no dispone del espacio suficiente."));
				exit;
			} 


			if (move_uploaded_file($_FILES['ficheros']['tmp_name'][$i], $ficheroSubido)) {
				$mensaje.=basename($_FILES['ficheros']['name'][$i])." subido con éxito. ";
				$nombre_=basename($_FILES['ficheros']['name'][$i]);
				$tamanyo_=$_FILES['ficheros']['size'][$i];
				$tipo_=$_FILES['ficheros']['type'][$i];
                $usuario_= $usuarioH;
				mysqli_stmt_execute($consulta);
				$espacioDisponible -= $tamanyo_;
			} else {
				$mensaje.=basename($_FILES['ficheros']['name'][$i])." error desconocido. ";
			}
		break;
        case UPLOAD_ERR_NO_FILE:
			$mensaje.=basename($_FILES['ficheros']['name'][$i])." no existe. ";
			break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
			$mensaje.=basename($_FILES['ficheros']['name'][$i])." excede el límite. ";
			break;
        default:
            $mensaje.=basename($_FILES['ficheros']['name'][$i])." error desconocido. ";
    }
}
mysqli_stmt_close($consulta);
mysqli_close($canal);
header("Location: hdd.php?mensaje=".urlencode($mensaje));
?>