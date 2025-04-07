<?php
// Activar reporting de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establecer encabezados JSON de manera estricta
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once '../../config/conexion.php';

class PruebaController {
    protected $pdo;
    protected $modelo;

    public function __construct($pdo, $modelo) {
        $this->pdo = $pdo;
        $this->modelo = $modelo;
    }

    public function procesarSolicitud() {
        try {
            // Verificar método de solicitud
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                throw new Exception("Método no permitido");
            }

            // Leer datos de entrada
            $respuestasUsuario = json_decode(file_get_contents("php://input"), true);

            // Validación básica de JSON
            if ($respuestasUsuario === null) {
                throw new Exception("Datos JSON inválidos");
            }

            // Corregir la prueba usando el modelo
            $resultado = $this->modelo->corregirPrueba($respuestasUsuario);

            // Devolver resultado
            echo json_encode($resultado);
            exit;

        } catch (Exception $e) {
            // Enviar error como JSON
            echo json_encode([
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }
} 