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
  background: rgb(2, 73, 89);
  font-family: 'Open Sans', sans-serif;
}

.login {
  width: 400px;
  margin: 16px auto;
  font-size: 16px;
}

/* Reset top and bottom margins from certain elements */
.login-header,
.login p {
  margin-top: 0;
  margin-bottom: 0;
}

/* The triangle form is achieved by a CSS hack */
.login-triangle {
  width: 0;
  margin-right: auto;
  margin-left: auto;
  border: 12px solid transparent;
  border-bottom-color: rgb(0, 157, 132);
}

.login-header {
  background: rgb(0, 157, 132);
  padding: 20px;
  font-size: 1.4em;
  font-weight: normal;
  text-align: center;
  text-transform: uppercase;
  color: #fff;
}

.login-container {
  background: #ebebeb;
  padding: 12px;
}

/* Every row inside .login-container is defined with p tags */
.login p {
  padding: 12px;
}

.login input {
  box-sizing: border-box;
  display: block;
  width: 100%;
  border-width: 1px;
  border-style: solid;
  padding: 16px;
  outline: 0;
  font-family: inherit;
  font-size: 0.95em;
}

.login input[type="email"],
.login input[type="password"] {
  background: #fff;
  border-color: #bbb;
  color: #555;
}

/* Text fields' focus effect */
.login input[type="email"]:focus,
.login input[type="password"]:focus {
  border-color: #888;
}

.login input[type="submit"] {
  background: rgb(0, 157, 132);
  border-color: transparent;
  color: #fff;
  cursor: pointer;
}

.login input[type="submit"]:hover {
  background: rgb(0, 121, 125);
}

/* Buttons' focus effect */
.login input[type="submit"]:focus {
  border-color: #05a;
}

    </style>
</head>

<body>




    <?php
            //Este es cuadno ha habido un error en validacion de datos
            if(isset($_GET["mensaje"])){
                $mensaje=$_GET["mensaje"];
                echo "<script>alert('$mensaje');</script>";   
            }
            
        
                
            echo "<div class='login'>";
            echo "<div class='login-triangle'></div>";
            echo "<h2 class='login-header'>Iniciar sesion</h2>";
            echo "<form action='validar.php' method='post' class='login-container'>";
            echo "Nombre de usuario <input type='text' name='usuario' id='usuario'   /><br />";
            echo "Contraseña <input type='password' name='clave' id='clave'  /><br /> ";
            echo "<input type='submit' name='Login' id='login' value='Entrar'   /><br />";
            echo "</form>";
            echo "</div>";
                    
           
        
        
        ?>
</body>

</html>
