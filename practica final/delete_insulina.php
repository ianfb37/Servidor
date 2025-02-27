<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'control_insulina', 3307);

if (!isset($_SESSION['user_id'])) {
    die("Acceso no autorizado.");
}

// Obtener el ID del registro a eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar si el registro existe
    $stmt = $pdo->prepare("SELECT * FROM insulina WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    $insulina = $stmt->fetch();

    if (!$insulina) {
        die("Registro no encontrado.");
    }

    // Borrar el registro
    $stmt = $pdo->prepare("DELETE FROM insulina WHERE id = ?");
    $stmt->execute([$id]);

    echo "Registro de insulina eliminado con éxito.";
} else {
    echo "No se ha especificado un ID.";
}
?>