<?php
header('Content-Type: application/json');
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../../config/conexion.php'; // Ajusta la ruta si es necesario

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['idAprendiz']) || !isset($_SESSION['modulo_id'])) {
    echo json_encode(['error' => 'Sesión no válida']);
    exit;
}

$aprendizId = $_SESSION['idAprendiz'];
$moduloId = $_SESSION['modulo_id'];

// Obtener respuestas del frontend
$datos = json_decode(file_get_contents("php://input"), true);

if (!$datos || !is_array($datos)) {
    echo json_encode(['error' => 'Respuestas inválidas']);
    exit;
}

// Crear la prueba en la tabla Prueba
$fechaInicio = date('Y-m-d H:i:s');
$fechaFin = date('Y-m-d H:i:s');

$stmt = $conn->prepare("INSERT INTO Prueba (idAprendiz, idModulo, fechaHoraInicial, fechaHoraFinal) VALUES (?, ?, ?, ?)");
$stmt->bind_param( $aprendizId, $moduloId, $fechaInicio, $fechaFin);
$stmt->execute();
$idPrueba = $stmt->insert_id;
$stmt->close();

// Inicializar conteo de aciertos y errores
$aciertos = 0;
$fallos = 0;

// Recorrer las respuestas del usuario
foreach ($datos as $idPregunta => $idRespuesta) {
    // Verificar si la respuesta es correcta
    $stmt = $conn->prepare("SELECT esCorrecta FROM Respuesta WHERE idRespuesta = ? AND idPregunta = ?");
    $stmt->bind_param("ii", $idRespuesta, $idPregunta);
    $stmt->execute();
    $stmt->bind_result($esCorrecta);
    $stmt->fetch();
    $stmt->close();

    $resultado = $esCorrecta ? 1 : 0;

    // Insertar en la tabla Valoracion
    $stmt = $conn->prepare("INSERT INTO Valoracion (resultado, idPrueba, idPregunta, idRespuesta) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiii", $resultado, $idPrueba, $idPregunta, $idRespuesta);
    $stmt->execute();
    $stmt->close();

    // Sumar al conteo
    if ($resultado) {
        $aciertos++;
    } else {
        $fallos++;
    }
}

// Enviar respuesta al cliente
echo json_encode([
    'exito' => true,
    'aciertos' => $aciertos,
    'fallos' => $fallos,
    'mensaje' => 'Prueba corregida y registrada con éxito.'
]);
