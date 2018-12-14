<?php
include "../../seguridad/tema05/funciones.php";
inicioSesion();
session_destroy();
unset($_SESSION);
header("Location: login.php");
exit;
?>