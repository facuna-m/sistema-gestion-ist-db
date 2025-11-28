<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="phpfiles.css">
    <title>Instituto de Seguridad del Trabajo</title>
</head>
<body>
    <div class="page-container">
        <a href="main.html">
            <img src="Recursos\LogoIST2.png" alt="Instituto de Seguridad del Trabajo" class="titulo-imagen">
        </a>
        <?php
        include 'Conexion.php';

        // Determinar la acción a realizar
        $action = isset($_POST['action']) ? $_POST['action'] : null;
        $action1 = isset($_POST['action1']) ? $_POST['action1'] : null;
        $action2 = isset($_POST['action2']) ? $_POST['action2'] : null;
        $action3 = isset($_POST['action3']) ? $_POST['action3'] : null;

        if ($action === 'add') {
            if (isset($_POST['rut_cliente'], $_POST['id_capacitacion'], $_POST['registro_asistencia'], $_POST['fecha_inscripcion'])) {
                $rut_cliente = $_POST['rut_cliente'];
                $id_capacitacion = $_POST['id_capacitacion'];
                $registro_asistencia = $_POST['registro_asistencia'];
                $fecha_inscripcion = $_POST['fecha_inscripcion'];
                
                $sql = "INSERT INTO public.toma (rut_cliente, id_capacitacion, registro_asistencia, fecha_inscripcion)
                        VALUES('$rut_cliente', '$id_capacitacion', $registro_asistencia, '$fecha_inscripcion');";
            } else {
                echo "Faltan datos en el formulario.";
            }

        } elseif ($action1 === 'remove') {
            // Eliminar cliente
            $rut_cliente = $_POST['rut_cliente'];

            $sql = "DELETE FROM public.toma WHERE rut_cliente = '$rut_cliente'";

        } elseif ($action2 === 'edit') {
            // Editar cliente
            $rut_cliente = $_POST['rut_cliente'];
            $id_capacitacion = $_POST['id_capacitacion'];
            $registro_asistencia = $_POST['registro_asistencia'];
            $fecha_inscripcion = $_POST['fecha_inscripcion'];

            $sql = "UPDATE public.toma SET 
                        id_capacitacion = '$id_capacitacion',
                        registro_asistencia = '$registro_asistencia',
                        fecha_inscripcion = '$fecha_inscripcion',
                    WHERE rut_cliente = '$rut_cliente'";


        } elseif ($action3 === 'consulta') {
            // Consultar cliente
            $rut_cliente = $_POST['rut_cliente'];

            $sql = "SELECT * FROM toma WHERE rut_cliente = '$rut_cliente'";
            $result = pg_query($conexion, $sql);

            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    echo "rut: " . $row['rut_cliente'] . "<br>";
                    echo "id capacitacion: " . $row['id_capacitacion'] . "<br>";
                    echo "registro de asistencia: " . $row['registro_asistencia'] . "<br>";
                    echo "fecha de inscripcion: " . $row['fecha_inscripcion'] . "<br>";
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
    </div>
</body>
