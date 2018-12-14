<?php
require_once("../../seguridad/ficheros/sesionesbd.php");
 


if (!isset($_FILES['ficheros'])){
	header("Location: hdd.php");
	exit;
}
if (!is_array($_FILES['ficheros']['name'])){
	header("Location: hdd.php");
	exit;
}

$numeroFicherosSubidos=count($_FILES['ficheros']['name']);
$canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);


if (mysqli_connect_errno()) {
    printf("Error de conexión: %s\n", mysqli_connect_error());
    exit();
}

$sql="insert into ficheros (id,nombre,tamanyo,tipo,usuario) values (?,?,?,?,?);";
$consulta=mysqli_prepare($canal,$sql);
mysqli_stmt_bind_param($consulta,"ssis",$id_,$nombre_,$tamanyo_,$tipo_,$usuario_);
$mensaje="";
for($i=0;$i<$numeroFicherosSubidos;$i++){
	switch ($_FILES['ficheros']['error'][$i]) {
        case UPLOAD_ERR_OK:
			$id_=uniqid('',true);
			$ficheroSubido = __ALMACEN__.$id_;
			if (move_uploaded_file($_FILES['ficheros']['tmp_name'][$i], $ficheroSubido)) {
				$mensaje.=basename($_FILES['ficheros']['name'][$i])." subido con éxito. ";
				$nombre_=basename($_FILES['ficheros']['name'][$i]);
				$tamanyo_=$_FILES['ficheros']['size'][$i];
				$tipo_=$_FILES['ficheros']['type'][$i];
                $usuario_=$_FILES['usuario']['type'][$i];
				mysqli_stmt_execute($consulta);
			} else {
				$mensaje.=basename($_FILES['ficheros']['name'][$i])." error desconocido. ";
			}
		break;
        case UPLOAD_ERR_NO_FILE:
            $mensaje.=basename($_FILES['ficheros']['name'][$i])." no existe. ";
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $mensaje.=basename($_FILES['ficheros']['name'][$i])." excede el límite. ";
        default:
            $mensaje.=basename($_FILES['ficheros']['name'][$i])." error desconocido. ";
    }
}
mysqli_stmt_close($consulta);
mysqli_close($canal);
header("Location: formularioSubida.php?mensaje=".urlencode($mensaje))
?>