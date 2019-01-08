<?php
include "../../seguridad/tema05/funciones.php";
include "../../seguridad/tema05/menu-s.php";
require_once("../../seguridad/tema05/sesionesbd.php");
?>
<?php 
    
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

                    $espacioDisponible = $cuota - $espacioUsado;
                    $espacioDisponible = $espacioDisponible / 1048576;

                    
                    mysqli_stmt_close($consulta);
                    unset($consulta);
                

    
    
?>
<!DOCTYPE html>
<html>

<head>
    <title>TITULO</title>
    <meta charset="utf-8">
    <!--<link rel="stylesheet" type="text/css" href="estilos.css" />-->
    <!--<script src="script.js"></script>-->
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

        body {
            font-family: 'Open Sans', sans-serif;
        }
        
        header {
            padding: 20px;
            font-size: 2em;
            font-weight: bold;
            background-color: rgb(0, 157, 132);
            color: white;
            margin-bottom: 15px;
        }

        nav {
            width: 200px;
            float: left;
            height: 100%;
        }

        .menu {
            display: block;
            border: 1px solid black;
            text-decoration: none;
            font-family: verdana;
            font-size: .8em;
            background-color: #cacaca;
            color: white;
            width: 150px;
            padding: 5px;
            text-align: center;
        }



        #cerrar {
            text-align: right;
            font-size: .3em;
        }

        #id {
            text-align: center;
            font-size: 20px;
        }

        #footer {
            position: fixed;
            left: 0px;
            bottom: 0px;
            height: 30px;
            width: 100%;
            background: #999;
            font-size: .8em;
            font-weight: bold;
            color: white;
        }

        .enlaceboton {
            text-decoration: none;
            color: white;
            border: 1px solid black;
            padding: 3px;
            background-color: black;
        }


        .button {
            background-color: #4CAF50;
            /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            -webkit-transition-duration: 0.4s;
            /* Safari */
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .button1 {
            background-color: white;
            color: black;
            border: 2px solid rgb(2, 73, 89);
        }

        .button1:hover {
            background-color: rgb(2, 73, 89);
            color: white;
        }

        #espacio {
            text-align: right;
        }

        #tablaFicheros{
            margin : 0 auto;
            border : 2px solid black;
        }
        

        tr{
            border: 2px solid blue;
        }
        table{
            margin : 0 auto;
            border : 2px solid black;
        }
        th{
            align: left;
        }


    </style>



</head>

<body>
   <?php
    //Mostrar mensaje
    if(isset($_GET["mensaje"])){
        $mensaje=$_GET["mensaje"];
        echo "<script>alert('$mensaje');</script>";   
    }
    ?>

    <header>
        Menú
        <div id="id">
            Usuario:
            <?='  '.$usuario?>
        </div>

        <div id="cerrar">
            <a href='cerrar.php' class='button button1'>Cerrar Sesión</a>
        </div>
    </header>
  

        <h1>Disco virtual</h1>
        <div id="espacio">
           
            <h3>Espacio disponible:
                <?='  '.$espacioDisponible?>MB
            </h3>
        </div>
        <br /><br />
        
    
        
        
        <section>
            <article>
                <?php 
                    $canal=@mysqli_connect(IP,USUARIO,CLAVE,BD);
                    if (!$canal){
                        echo "Ha ocurrido el error: ".mysqli_connect_errno()." ".mysqli_connect_error()."<br />";
                    exit;
                    }
                    mysqli_set_charset($canal,"utf8");

                    $sql="select id, nombre, tamanyo from ficheros where usuario=? order by nombre";


                    $consulta=mysqli_prepare($canal,$sql);
                    if (!$consulta){
                        echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
                    exit;	
                    }
                    mysqli_stmt_bind_param($consulta,"s",$uusuario);
                    $uusuario=$usuario;

                    mysqli_stmt_execute($consulta);
                    mysqli_stmt_bind_result($consulta, $id, $nombre,$tamanyo);
                    echo"<table id='tablaFicheros'><caption>Ficheros</caption>";
                    echo "<tr><th>Nombre</th><th>Tamaño</th><th></th><th></th></tr>";
                    while(mysqli_stmt_fetch($consulta)){
                        echo "<tr>";
                        echo "<td>$nombre</td><td>$tamanyo</td>";
                        ?>
                        <td>
                            <form action="borrar.php" method="post">
                                <input type="hidden" name="id" value="<?=$id?>" />
                                <input type="submit" value="Borrar" />
                            </form>
                        </td>
                        <td>
                            <form action="descargar.php" method="post">
                                <input type="hidden" name="id" value="<?=$id?>" />
                                <input type="submit" value="Descargar" />
                            </form>
                        </td>
                        <?php
                        echo "</tr>";
                            }
                            echo"</table>";
                            mysqli_stmt_close($consulta);
                            unset($consulta);
                        ?>
            </article>

            <article>

                <hr style="width: 100%;" />
                <form enctype="multipart/form-data" action="subir.php" method="post">
                   <input type="hidden" value="<?=$usuario?>" name="usuarioH" />
                    <table>
                        <caption>Carga de ficheros</caption>

                        <tr>
                            <td>Fichero(s):<input type="hidden" name="MAX_FILE_SIZE" value="2000500000" /></td>
                        </tr>

                        <tr>
                            
                            <td><input type="file" name="ficheros[]" multiple="multiple" /></td>
                            <td></td>
                        </tr>

                        <tr>
                           
                            <td colspan="2"><input type="submit" value="Subir" />
                        </tr>
                    </table>
                </form>
            </article>
        </section>






</body>

</html>
