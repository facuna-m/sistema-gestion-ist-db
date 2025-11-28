<?php
$equipo= "";
$namebd= "";
$puerto= "";
$usuario= ""; 
$clave= "";     


$conexion = pg_connect("host= $equipo
                        dbname=$namebd
                        port=$puerto
                        user=$usuario
                        password=$clave
                        ");

if (!$conexion) {
    die("Error de conexión a la base de datos.");
}                        
?>