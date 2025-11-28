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
            <img src="Recursos\LogoIST2.png" alt="Instituto de Seguridad del Trabajo" class="titulo-imagen"> <br>
        </a>
        <?php
        include 'Conexion.php';

        // Determinar la acción a realizar
        $action = isset($_POST['action']) ? $_POST['action'] : null;
        $action1 = isset($_POST['action1']) ? $_POST['action1'] : null;
        $action2 = isset($_POST['action2']) ? $_POST['action2'] : null;
        $action3 = isset($_POST['action3']) ? $_POST['action3'] : null;

        if ($action === 'add') {
            if (isset($_POST['rut'], $_POST['nombre'], $_POST['telefono'], $_POST['direccion'], $_POST['fdn'], $_POST['fda'], $_POST['id_empresa'])) {
                $rut = $_POST['rut'];
                $nombre = $_POST['nombre'];
                $telefono = $_POST['telefono'];
                $direccion = $_POST['direccion'];
                $fecha_nacimiento = $_POST['fdn'];
                $fecha_afiliacion = $_POST['fda'];
                $id_empresa = $_POST['id_empresa'];
                
                $sql = "INSERT INTO public.cliente (rut, nombre, telefono, direccion, fecha_nacimiento, id_empresa, fecha_afiliacion)
                        VALUES('$rut', '$nombre', $telefono, '$direccion', '$fecha_nacimiento', '$id_empresa', '$fecha_afiliacion');";
            } else {
                echo "Faltan datos en el formulario.";
            }

        } elseif ($action1 === 'remove') {
            // Eliminar cliente
            $rut = $_POST['rut'];

            $sql = "DELETE FROM cliente WHERE rut = '$rut'";

        } elseif ($action2 === 'edit') {
            // Editar cliente
            $rut = $_POST['rut'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $fecha_nacimiento = $_POST['fdn'];
            $fecha_afiliacion = $_POST['fda'];
            $id_empresa = $_POST['id_empresa'];

            $sql = "UPDATE public.cliente SET 
                        nombre = '$nombre',
                        telefono = '$telefono',
                        direccion = '$direccion',
                        fecha_nacimiento = '$fecha_nacimiento',
                        fecha_afiliacion = '$fecha_afiliacion',
                        id_empresa = '$id_empresa'
                    WHERE rut = '$rut'";


        } elseif ($action3 === 'consulta') {
            // Consultar cliente
            $rut = $_POST['rut'];

            $sql = "SELECT * FROM cliente WHERE rut = '$rut'";
            $result = pg_query($conexion, $sql);

            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    echo "Nombre: " . $row['nombre'] . "<br>";
                    echo "Teléfono: " . $row['telefono'] . "<br>";
                    echo "Dirección: " . $row['direccion'] . "<br>";
                    echo "Fecha de nacimiento: " . $row['fecha_nacimiento'] . "<br>";
                    echo "Fecha de afiliacion: " . $row['fecha_afiliacion'] . "<br>";
                    echo "Id de la Empresa: " . $row['id_empresa'] . "<br>";
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
