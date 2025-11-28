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
            <img src="..\Recursos\LogoIST2.png" alt="Instituto de Seguridad del Trabajo" class="titulo-imagen"> <br>
        </a>
        <?php
        include 'Conexion.php';

        // Determinar la acción a realizar
        $action = isset($_POST['action']) ? $_POST['action'] : null;
        $action1 = isset($_POST['action1']) ? $_POST['action1'] : null;
        $action2 = isset($_POST['action2']) ? $_POST['action2'] : null;
        $action3 = isset($_POST['action3']) ? $_POST['action3'] : null;

        if ($action === 'add') {
            if (isset($_POST['id'], $_POST['telefono'], $_POST['gerente'], $_POST['direccion'])) {
                $id = $_POST['id'];
                $telefono = $_POST['telefono'];
                $gerente = $_POST['gerente'];
                $direccion = $_POST['direccion'];
                
                $sql = "INSERT INTO public.sucursal (id, telefono, gerente, direccion)
                        VALUES('$id', '$telefono', '$gerente', '$direccion');";
            } else {
                echo "Faltan datos en el formulario.";
            }

        } elseif ($action1 === 'remove') {
            // Eliminar cliente
            $id = $_POST['id'];

            $sql = "DELETE FROM public.sucursal WHERE id = '$id'";

        } elseif ($action2 === 'edit') {
            // Editar cliente
            $id = $_POST['id'];
            $telefono = $_POST['telefono'];
            $gerente = $_POST['gerente'];
            $direccion = $_POST['direccion'];

            $sql = "UPDATE public.sucursal SET 
                        id = '$id',
                        telefono = '$telefono',
                        gerente = '$gerente',
                        direccion = '$direccion'
                    WHERE id = '$id'";


        } elseif ($action3 === 'consulta') {
            // Consultar cliente
            $id = $_POST['id'];

            $sql = "SELECT * FROM public.sucursal WHERE id = '$id'";
            $result = pg_query($conexion, $sql);

            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    echo "ID Sucursal: " . $row['id'] . "<br>";
                    echo "Nombre Gerente: " . $row['gerente'] . "<br>";
                    echo "Teléfono: " . $row['telefono'] . "<br>";
                    echo "Dirección " . $row['direccion'] . "<br>";
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
