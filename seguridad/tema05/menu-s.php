<?php
inicioSesion();
$usuario="";
$cuota="";
if (!validado($usuario,$cuota)){
	session_destroy();
	unset($_SESSION);
	header("Location: login.php");
	exit;
}
/*$menu=menu();*/
?>