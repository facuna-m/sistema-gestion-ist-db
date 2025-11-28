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
            if (isset($_POST['id'], $_POST['nombre_documento'], $_POST['fecha_emision'], $_POST['autor'], $_POST['tipo_documento'], $_POST['codigo_CPRR'], $_POST['id_empresa'])) {
                $id = $_POST['id'];
                $nombre_documento = $_POST['nombre_documento'];
                $fecha_emision = $_POST['fecha_emision'];
                $autor = $_POST['autor'];
                $tipo_documento = $_POST['tipo_documento'];
                $codigo_CPRR = $_POST['codigo_CPRR'];
                $id_empresa = $_POST['id_empresa'];
                
                $sql = "INSERT INTO public.documento_prevencion (id, nombre_documento, fecha_emision, autor, tipo_documento, \"codigo_CPRR\", id_empresa)
                        VALUES('$id', '$nombre_documento', '$fecha_emision', '$autor', '$tipo_documento', '$codigo_CPRR', '$id_empresa');";
            } else {
                echo "Faltan datos en el formulario.";
            }

        } elseif ($action1 === 'remove') {
            // Eliminar cliente
            $id = $_POST['id'];

            $sql = "DELETE FROM public.documento_prevencion WHERE id = '$id'";

        } elseif ($action2 === 'edit') {
            // Editar documento de prevencion
            $id = $_POST['id'];
            $nombre_documento = $_POST['nombre_documento'];
            $fecha_emision = $_POST['fecha_emision'];
            $autor = $_POST['autor'];
            $tipo_documento = $_POST['tipo_documento'];
            $codigo_CPRR = $_POST['codigo_CPRR'];
            $id_empresa = $_POST['id_empresa'];

            $sql = "UPDATE public.documento_prevencion SET 
                        nombre_documento = '$nombre_documento',
                        fecha_emision = '$fecha_emision',
                        autor = '$autor',
                        tipo_documento = '$tipo_documento',
                        \"codigo_CPRR\" = '$codigo_CPRR',
                        id_empresa = '$id_empresa'
                    WHERE id = '$id'";


        } elseif ($action3 === 'consulta') {
            // Consultar cliente
            $id = $_POST['id'];

            $sql = "SELECT * FROM public.documento_prevencion WHERE id = '$id'";
            $result = pg_query($conexion, $sql);

            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    echo "ID: " . $row['id'] . "<br>";
                    echo "Nombre del documento: " . $row['nombre_documento'] . "<br>";
                    echo "Fecha de Emisión: " . $row['fecha_emision'] . "<br>";
                    echo "Autor: " . $row['autor'] . "<br>";
                    echo "Codigo Centro Prevencion de Riesgos: " . $row['codigo_CPRR'] . "<br>";
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
