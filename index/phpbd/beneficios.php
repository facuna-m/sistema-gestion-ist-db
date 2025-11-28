<?php
include 'Conexion.php';

// Determinar la acción a realizar
$action = isset($_POST['action']) ? $_POST['action'] : null;
$action1 = isset($_POST['action1']) ? $_POST['action1'] : null;
$action2 = isset($_POST['action2']) ? $_POST['action2'] : null;
$action3 = isset($_POST['action3']) ? $_POST['action3'] : null;

if ($action === 'add') {
    if (isset($_POST['id'], $_POST['nombre'], $_POST['tipo_beneficio'], $_POST['fecha_inicio'], $_POST['fecha_termino'], $_POST['codigo_CA'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $tipo_beneficio = $_POST['tipo_beneficio'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_termino = $_POST['fecha_termino'];
        $codigo_CA = $_POST['codigo_CA'];
        $sql = "INSERT INTO public.beneficio (id, nombre, tipo_beneficio, fecha_inicio, fecha_termino, \"codigo_CA\")
                VALUES('$id', '$nombre', '$tipo_beneficio', '$fecha_inicio', '$fecha_termino', '$codigo_CA');";
    } else {
        echo "Faltan datos en el formulario.";
    }

} elseif ($action1 === 'remove') {
    // Eliminar cliente
    $id = $_POST['id'];

    $sql = "DELETE FROM public.beneficio WHERE beneficio.id = '$id'";   
    

} elseif ($action2 === 'edit') {
    // Editar cliente
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $tipo_beneficio = $_POST['tipo_beneficio'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_termino = $_POST['fecha_termino'];
    $codigo_CA = $_POST['codigo_CA'];

    $sql = "UPDATE public.beneficio
            SET nombre='$nombre', tipo_beneficio='$tipo_beneficio', fecha_inicio='$fecha_inicio', fecha_termino ='$fecha_termino', \"codigo_CA\" = '$codigo_CA'
            WHERE id='$id';";


} elseif ($action3 === 'consulta') {
    // Consultar cliente
    $id = $_POST['id'];

    $sql = "SELECT * FROM public.beneficio WHERE id = '$id'";
    $result = pg_query($conexion, $sql);

    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            echo "ID Beneficio: " . $row['id'] . "<br>";
            echo "Nombre: " . $row['nombre'] . "<br>";
            echo "Tipo: " . $row['tipo_beneficio'] . "<br>";
            echo "Fecha de inicio:  " . $row['fecha_inicio'] . "<br>";
            echo "Fecha de termino  " . $row['fecha_termino'] . "<br>";
            echo "Código Centro Atencion:  " . $row['codigo_CA'] . "<br>";

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
