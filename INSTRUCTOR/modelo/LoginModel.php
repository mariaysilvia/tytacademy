<?php
require_once '../../ADMINISTRADOR/modelo/InstructorModel.php';

class LoginModel {
    private $pdo;
    private $instructorModel;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->instructorModel = new InstructorModel($pdo);
    }
    
    // Verifica las credenciales del instructor
    // @param array $datos Datos de login (documento, email, clave)
    // @return array|false Datos del instructor si el login es exitoso, false si no
    public function verificarCredenciales($datos) {
        if (empty($datos['documento']) || empty($datos['email']) || empty($datos['clave'])) {
            error_log("LoginModel: Datos incompletos recibidos");
            return false;
        }
        
        error_log("LoginModel: Verificando credenciales para documento: " . $datos['documento'] . ", email: " . $datos['email']);
        
        $resultado = $this->instructorModel->login(
            $datos['documento'],
            $datos['email'],
            $datos['clave']
        );
        
        error_log("LoginModel: Resultado de login: " . ($resultado ? "éxito" : "fallo"));
        
        return $resultado;
    }
    
    // Inicia la sesión del instructor
    // @param array $instructor Datos del instructor
    // @return bool True si se inició la sesión correctamente
    public function iniciarSesion($instructor) {
        if (!session_id()) {
            session_start();
        }
        $_SESSION['instructor'] = $instructor;
        return true;
    }
    
    // Verifica si hay una sesión de instructor activa
    // @return bool True si hay una sesión activa
    public function verificarSesion() {
        if (!session_id()) {
            session_start();
        }
        return isset($_SESSION['instructor']);
    }
    
    // Cierra la sesión del instructor
    public function cerrarSesion() {
        if (!session_id()) {
            session_start();
        }
        unset($_SESSION['instructor']);
        session_destroy();
        return true;
    }
} 