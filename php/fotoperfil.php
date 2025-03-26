<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "basededatostytacademy");

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idAprendiz = $_POST['idAprendiz'];
        $fotoPredeterminada = '../image/default-profile.png';

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
        } else {
            $foto = file_get_contents($fotoPredeterminada);
        }

        $stmt = $conn->prepare("UPDATE Aprendiz SET foto_perfil = ? WHERE idAprendiz = ?");
        $stmt->bind_param("bi", $foto, $idAprendiz);
        $stmt->send_long_data(0, $foto);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Foto actualizada correctamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar la foto."]);
        }

        $stmt->close();
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error en el servidor: " . $e->getMessage()]);
}

$conn->close();
?>
