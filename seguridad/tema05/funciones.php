
<?php
function inicioSesion(){
	session_name("SESION");
	session_cache_limiter('private,nocache');
	session_start();
}

function validado(&$usuario,&$cuota){
	$validado=false;
	if (isset($_SESSION['validado']) && $_SESSION['validado']){
		$validado=true;
		$usuario=$_SESSION['usuario'];
		$cuota=$_SESSION['cuota'];
	}
	return $validado;
}

/*function menu(){
	return $_SESSION['menu'];
}*/



?>