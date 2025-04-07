<?php
// Iniciar sesión al principio
session_start();

// Configuración de errores más detallada
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inicio de captura de salida
ob_start();

require_once '../../config/conexion.php';
require_once '../modelo/AprendizModel.php';

try {
    // Verificar si el archivo de conexión existe
    $conexionPath = '../../config/conexion.php';
    if (!file_exists($conexionPath)) {
        throw new Exception("Archivo de conexión no encontrado en: " . realpath($conexionPath));
    }

    // Incluir archivo de conexión
    require_once $conexionPath;

    // Verificar si $pdo está definido
    if (!isset($pdo) || !$pdo) {
        throw new Exception("Conexión PDO no establecida");
    }

    // Loguear todos los datos recibidos
    error_log("Método recibido: " . $_SERVER['REQUEST_METHOD']);
    error_log("POST recibido: " . print_r($_POST, true));
    error_log("FILES recibido: " . print_r($_FILES, true));
    error_log("Directorio actual: " . getcwd());

    if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
        throw new Exception("ID de aprendiz no proporcionado o sesión no iniciada");
    }

    $idAprendiz = $_SESSION['usuario_id'];
    $aprendizModel = new AprendizModel($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Manejar la acción para obtener el ID del aprendiz
        if (isset($_POST['action']) && $_POST['action'] === 'getIdAprendiz') {
            echo json_encode([
                "success" => true,
                "idAprendiz" => $aprendizModel->obtenerIdAprendiz($idAprendiz)
            ]);
            exit;
        }

        // Ruta del directorio de imágenes
        $directorioBase = $_SERVER['DOCUMENT_ROOT'] . '/trabajos/PruebasTYT/APRENDIZ/image/';
        error_log("Ruta base del directorio: " . $directorioBase);

        // Verificar si el directorio de imágenes existe
        if (!is_dir($directorioBase)) {
            if (!mkdir($directorioBase, 0777, true)) {
                throw new Exception("No se pudo crear el directorio de imágenes: " . $directorioBase);
            }
            error_log("Directorio de imágenes creado: " . $directorioBase);
        }

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Generar un nombre único para el archivo
            $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $nombreArchivo = uniqid('foto_', true) . '.' . $extension;
            $rutaDestino = $directorioBase . $nombreArchivo;
            $rutaRelativa = 'image/' . $nombreArchivo;

            error_log("Ruta destino completa: " . $rutaDestino);
            error_log("Ruta relativa: " . $rutaRelativa);

            // Mover el archivo
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                // Actualizar la foto en la base de datos
                if ($aprendizModel->actualizarFotoPerfil($idAprendiz, $rutaRelativa)) {
                    echo json_encode([
                        "success" => true, 
                        "message" => "Foto actualizada correctamente",
                        "rutaFoto" => $rutaRelativa
                    ]);
                } else {
                    throw new Exception("Error al actualizar la foto en la base de datos");
                }
            } else {
                throw new Exception("No se pudo mover el archivo a " . $rutaDestino);
            }
        } else {
            throw new Exception("No se recibió una foto válida o hubo un error al subirla: " . $_FILES['foto']['error']);
        }
    } else {
        throw new Exception("Método no permitido: " . $_SERVER['REQUEST_METHOD']);
    }
} catch (Exception $e) {
    // Loguear el error completo
    error_log("Excepción capturada: " . $e->getMessage());
    error_log("Traza: " . $e->getTraceAsString());

    // Enviar respuesta de error
    echo json_encode([
        "success" => false, 
        "message" => "Error en el servidor: " . $e->getMessage(),
        "error_details" => $e->getMessage()
    ]);
}

// Limpiar el búfer de salida
ob_end_flush();
?>