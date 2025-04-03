<?php
header('Content-Type: application/json');
ob_start(); // Inicia el buffer de salida
include '../config/conexion.php'; // Asegúrate de que la ruta sea correcta

// Mostrar errores para depuración (puedes desactivarlo en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"));
error_log("Datos recibidos: " . json_encode($data)); // Agregado para depuración

try {
    if ($data && isset($data->action)) {
        error_log("Acción recibida: " . $data->action); // Agregado para depuración
        if ($data->action === 'getModulos') {
            // Obtener los módulos desde la base de datos
            $stmt = $pdo->query("SELECT idModulo, modulo FROM Modulo");
            $modulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Verificar si hay módulos
            ob_clean(); // Limpia cualquier salida previa
            if (empty($modulos)) {
                echo json_encode(['success' => false, 'message' => 'No hay módulos disponibles.']);
            } else {
                echo json_encode(['success' => true, 'data' => $modulos]);
            }
        } elseif ($data->action === 'guardarInstructor') {
            error_log("Datos recibidos para guardar: " . json_encode($data)); // Agregado para depuración

            $documento = $data->documento;
            $nombre = $data->nombre;
            $apellido = $data->apellido;
            $email = $data->email;
            $clave = password_hash($data->clave, PASSWORD_BCRYPT);
            $celular = $data->celular;
            $modulo = $data->modulo;

            // Verificar que los datos obligatorios no estén vacíos
            if (!$documento || !$nombre || !$apellido || !$email || !$clave || !$modulo) {
                error_log("❌ Campos obligatorios faltantes"); // Agregado para depuración
                ob_clean(); // Limpia cualquier salida previa
                echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados.']);
                exit;
            }

// Preparar la consulta SQL con PDO
$stmt = $pdo->prepare("INSERT INTO Instructor (documento, nombre, apellido, email, clave, celular, idModulo) VALUES (?, ?, ?, ?, ?, ?, ?)");
if ($stmt->execute([$documento, $nombre, $apellido, $email, $clave, $celular, $modulo])) {
    error_log("✅ Instructor guardado exitosamente"); // Agregado para depuración
    ob_clean(); // Limpia cualquier salida previa
    echo json_encode(['success' => true, 'message' => 'Instructor guardado exitosamente.']);
    exit; // Detener la ejecución del script después de enviar la respuesta

    // Llama a la función enviarCorreoBienvenida
    try {
        require_once 'emailinstructor.php';
        $correoEnviado = enviarCorreoBienvenida($nombre, $email, $data->clave, $modulo); // Asegúrate de pasar todos los parámetros necesarios
        if (!$correoEnviado) {
            error_log("❌ Error al enviar el correo de bienvenida.");
        }
    } catch (Exception $e) {
        error_log("Error al enviar el correo: " . $e->getMessage()); // Agregado para depuración
    }
} else {
    error_log("❌ Error al ejecutar la consulta SQL: " . json_encode($stmt->errorInfo())); // Agregado para depuración
    ob_clean(); // Limpia cualquier salida previa
    echo json_encode(['success' => false, 'message' => 'Error al guardar el instructor en la base de datos.']);
    exit; // Detener la ejecución del script después de enviar la respuesta
} } else {
            ob_clean(); // Limpia cualquier salida previa
            echo json_encode(['success' => false, 'message' => 'Acción no válida.']);
        }
    } else {
        ob_clean(); // Limpia cualquier salida previa
        echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
    }

} catch (Exception $e) {
    error_log("Error en el servidor: " . $e->getMessage()); // Agregado para depuración
    ob_clean(); // Limpia cualquier salida previa
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

ob_end_flush(); // Envía la salida del buffer
?>
