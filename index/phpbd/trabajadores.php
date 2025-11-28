<?php
include 'Conexion.php';

// Determinar la acción a realizar
$action = isset($_POST['action']) ? $_POST['action'] : null;
$action1 = isset($_POST['action1']) ? $_POST['action1'] : null;
$action2 = isset($_POST['action2']) ? $_POST['action2'] : null;
$action3 = isset($_POST['action3']) ? $_POST['action3'] : null;

if ($action === 'add') {
    if (isset($_POST['rut'], $_POST['id_sucursal'], $_POST['nombre'], $_POST['telefono'], $_POST['direccion'], $_POST['correo'], $_POST['area_trabajo'])) {
        $rut = $_POST['rut'];
        $id_sucursal = $_POST['id_sucursal'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];
        $area_trabajo = $_POST['area_trabajo'];
        $sql = "INSERT INTO public.trabajador_ist (rut, id_sucursal, nombre, telefono, direccion, correo, area_trabajo)
                VALUES('$rut', '$id_sucursal', '$nombre', '$telefono', '$direccion', '$correo', '$area_trabajo');";
    } else {
        echo "Faltan datos en el formulario.";
    }

} elseif ($action1 === 'remove') {
    // Eliminar cliente
    $rut = $_POST['rut'];

    $sql = "DELETE FROM public.trabajador_ist WHERE rut = '$rut'";   
    

} elseif ($action2 === 'edit') {
    // Editar cliente
    $rut = $_POST['rut'];
    $id_sucursal = $_POST['id_sucursal'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $area_trabajo = $_POST['area_trabajo'];

    $sql = "UPDATE public.trabajador_ist
            SET id_sucursal='$id_sucursal', nombre='$nombre', telefono='$telefono', direccion='$direccion', correo='$correo', area_trabajo='$area_trabajo'
            WHERE rut='$rut';";


} elseif ($action3 === 'consulta') {
    // Consultar cliente
    $rut = $_POST['rut'];

    $sql = "SELECT * FROM public.trabajador_ist WHERE rut = '$rut'";
    $result = pg_query($conexion, $sql);

    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            echo "Rut: " . $row['rut'] . "<br>";
            echo "ID Sucursal: " . $row['id_sucursal'] . "<br>";
            echo "Nombre: " . $row['nombre'] . "<br>";
            echo "Telefono: " . $row['telefono'] . "<br>";
            echo "Direccion:  " . $row['direccion'] . "<br>";
            echo "Correo  " . $row['correo'] . "<br>";
            echo "Area trabajo:  " . $row['area_trabajo'] . "<br>";
        }
    } else {
        echo "Error al consultar: " . pg_last_error($conexion);
    }
    exit; // Salir para evitar ejecutar código innecesario
}

if (isset($sql)) {
    $result = pg_query($conexion, $sql);

    if ($result) {
        echo "Operación realizada con éxito.";
    } else {
        echo "Error en la operación: " . pg_last_error($conexion);
        echo "<br>Consulta ejecutada: " . $sql; // Esto muestra la consulta para depuración
    }
}

pg_close($conexion);
?>
