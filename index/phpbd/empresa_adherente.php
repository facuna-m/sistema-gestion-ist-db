<?php
include 'Conexion.php';

// Determinar la acción a realizar
$action = isset($_POST['action']) ? $_POST['action'] : null;
$action1 = isset($_POST['action1']) ? $_POST['action1'] : null;
$action2 = isset($_POST['action2']) ? $_POST['action2'] : null;
$action3 = isset($_POST['action3']) ? $_POST['action3'] : null;

if ($action === 'add') {
    if (isset($_POST['id'], $_POST['nombre'], $_POST['telefono'], $_POST['direccion'], $_POST['sector'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $sector = $_POST['sector'];
        $direccion = $_POST['direccion'];
        
        $sql = "INSERT INTO public.empresa (id, nombre, sector, direccion, telefono)
                VALUES('$id', '$nombre', '$sector', '$direccion', '$telefono');";
    } else {
        echo "Faltan datos en el formulario.";
    }

} elseif ($action1 === 'remove') {
    // Eliminar cliente
    $id = $_POST['id'];

    $sql = "DELETE FROM public.empresa WHERE empresa.id = '$id'";   
    

} elseif ($action2 === 'edit') {
    // Editar cliente
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $sector = $_POST['sector'];
    $direccion = $_POST['direccion'];

    $sql = "UPDATE public.empresa
            SET nombre='$nombre', sector='$sector', direccion='$direccion', telefono='$telefono'
            WHERE id='$id';";


} elseif ($action3 === 'consulta') {
    // Consultar cliente
    $id = $_POST['id'];

    $sql = "SELECT * FROM public.empresa WHERE id = '$id'";
    $result = pg_query($conexion, $sql);

    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            echo "Id Empresa: " . $row['id'] . "<br>";
            echo "Nombre: " . $row['nombre'] . "<br>";
            echo "Telefono: " . $row['telefono'] . "<br>";
            echo "Sector:  " . $row['sector'] . "<br>";
            echo "Direccion:  " . $row['direccion'] . "<br>";

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
