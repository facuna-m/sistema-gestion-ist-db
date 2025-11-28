<?php
// Conexión a la base de datos
$host = "localhost";
$dbname = "ist_proyecto";
$user = "";
$password = "";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    // ... otros datos ...

    // Procesar según el botón
    if (isset($_POST['guardar'])) {
        // Insertar nuevo registro
        $sql = "INSERT INTO tu_tabla (id, nombre, ...) VALUES (:id, :nombre, ...)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id, ':nombre' => $nombre, ...]);
    } elseif (isset($_POST['modificar'])) {
        // Actualizar registro
        $sql = "UPDATE tu_tabla SET nombre = :nombre WHERE id = :id";
        // ...
    } elseif (isset($_POST['eliminar'])) {
        // Eliminar registro
        $sql = "DELETE FROM tu_tabla WHERE id = :id";
        // ...
    } elseif (isset($_POST['consultar'])) {
        // Consultar datos
        $sql = "SELECT * FROM tu_tabla";
        $stmt = $pdo->query($sql);
        // Mostrar resultados en una tabla HTML
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>