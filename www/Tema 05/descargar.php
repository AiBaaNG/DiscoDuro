<?php
require_once("../../seguridad/tema05/sesionesbd.php");
if (!isset($_POST['id'])){
	header("Location: hdd.php");
	exit;
}
$id=$_POST['id'];

$canal=@mysqli_connect(IP,USUARIO,CLAVE,BD);
	
if (!$canal){
	echo "Ha ocurrido el error: ".mysqli_connect_errno()." ".mysqli_connect_error()."<br />";
	exit;
}
mysqli_set_charset($canal,"utf8");

$sql="select nombre, tamanyo, tipo from ficheros where id=?";
$consulta=mysqli_prepare($canal,$sql);
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
	exit;
}
mysqli_stmt_bind_param($consulta,"s",$id1);
mysqli_stmt_bind_result($consulta,$nombre_,$tamanyo_,$tipo_);
$id1=$id;
mysqli_stmt_execute($consulta);
mysqli_stmt_store_result($consulta);
$n=mysqli_stmt_num_rows($consulta);

if ($n!=1){
	header("Location: hdd.php");
	exit;
}
mysqli_stmt_fetch($consulta);

header("Content-disposition: attachment; filename=$nombre_");
header("Content-type: $tipo_");
readfile(__ALMACEN__.$id);
?>
?>