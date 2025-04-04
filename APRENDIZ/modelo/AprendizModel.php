<?php
//Clase AprendizModel
//Maneja todas las operaciones relacionadas con los aprendices en la base de datos,
//incluyendo registro, validación y gestión de datos de aprendices.
class AprendizModel {
    //Instancia de conexión a la base de datos
    private $pdo;
    
    //Constructor de la clase
    //@param PDO $pdo Conexión a la base de datos
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    //Valida los datos del aprendiz antes de guardarlos
    //@param array $datos Datos del aprendiz a validar
    //@return bool True si los datos son válidos, False en caso contrario
    public function validarDatos($datos) {
        return !empty($datos['documento']) && 
               !empty($datos['nombres']) && 
               !empty($datos['apellidos']) && 
               !empty($datos['correo']) && 
               !empty($datos['clave']);
    }
    
    //Guarda un nuevo aprendiz en la base de datos
    //@param array $datos Datos del aprendiz a guardar
    //@return bool True si se guardó correctamente, False en caso contrario
    public function guardarAprendiz($datos) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Aprendiz (documento, nombres, apellidos, correo, clave) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([
                $datos['documento'],
                $datos['nombres'],
                $datos['apellidos'],
                $datos['correo'],
                $datos['clave']
            ]);
        } catch (PDOException $e) {
            error_log("Error al guardar aprendiz: " . $e->getMessage());
            return false;
        }
    }
    
    //Verifica si un correo electrónico ya está registrado
    //@param string $correo Correo electrónico a verificar
    //@return bool True si el correo ya existe, False en caso contrario
    public function verificarCorreoExistente($correo) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Aprendiz WHERE correo = ?");
        $stmt->execute([$correo]);
        return $stmt->fetchColumn() > 0;
    }
    
    //Verifica si un documento ya está registrado
    //@param string $documento Documento a verificar
    //@return bool True si el documento ya existe, False en caso contrario
    public function verificarDocumentoExistente($documento) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Aprendiz WHERE documento = ?");
        $stmt->execute([$documento]);
        return $stmt->fetchColumn() > 0;
    }
} 