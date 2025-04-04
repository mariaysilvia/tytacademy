<?php
//Clase InstructorModel
//Maneja todas las operaciones relacionadas con los instructores en la base de datos,
//incluyendo creación, validación y gestión de datos de instructores.
class InstructorModel {
    //Instancia de conexión a la base de datos
    private $pdo;
    
    //Constructor de la clase
    //@param PDO $pdo Conexión a la base de datos
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    //Valida los datos del instructor antes de guardarlos
    // $datos Datos del instructor a validar
    // True si los datos son válidos, False en caso contrario
    public function validarDatos($datos) {
        return !empty($datos['nombre']) && 
            !empty($datos['email']) && 
            !empty($datos['clave']) && 
            !empty($datos['modulo']);
    }
    
    //Guarda un nuevo instructor en la base de datos
    //@param array $datos Datos del instructor a guardar
    //True si se guardó correctamente, False en caso contrario
    public function guardarInstructor($datos) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Instructor (nombre, email, clave, idModulo) VALUES (?, ?, ?, ?)");
            return $stmt->execute([
                $datos['nombre'],
                $datos['email'],
                $datos['clave'],
                $datos['modulo']
            ]);
        } catch (PDOException $e) {
            error_log("Error al guardar instructor: " . $e->getMessage());
            return false;
        }
    }
    
    //Obtiene todos los módulos disponibles
    // Lista de módulos disponibles
    public function getModulos() {
        try {
            $stmt = $this->pdo->query("SELECT idModulo, modulo FROM Modulo");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener módulos: " . $e->getMessage());
            return [];
        }
    }
} 