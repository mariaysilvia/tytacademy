<?php
/**
 * Clase InstructorModel
 * Maneja todas las operaciones relacionadas con los instructores en la base de datos
 */
class InstructorModel {
    private $pdo;
    
    /**
     * Constructor de la clase
     * @param PDO $pdo Conexión a la base de datos
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Obtiene todos los módulos disponibles
     * @return array Lista de módulos
     * @throws Exception Si hay un error en la consulta
     */
    public function getModulos() {
        try {
            $sql = "SELECT idModulo, modulo FROM Modulo ORDER BY modulo ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getModulos: " . $e->getMessage());
            throw new Exception("Error al obtener los módulos: " . $e->getMessage());
        }
    }
    
    /**
     * Guarda un nuevo instructor en la base de datos
     * @param array $datos Datos del instructor
     * @return bool Resultado de la operación
     */
    public function guardarInstructor($datos) {
        $stmt = $this->pdo->prepare("INSERT INTO Instructor (documento, nombre, apellido, email, clave, celular, idModulo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $datos['documento'],
            $datos['nombre'],
            $datos['apellido'],
            $datos['email'],
            $datos['clave'],
            $datos['celular'],
            $datos['modulo']
        ]);
    }
    
    /**
     * Valida los datos del instructor
     * @param array $datos Datos a validar
     * @return bool Resultado de la validación
     */
    public function validarDatos($datos) {
        return !empty($datos['documento']) && 
               !empty($datos['nombre']) && 
               !empty($datos['apellido']) && 
               !empty($datos['email']) && 
               !empty($datos['clave']) && 
               !empty($datos['modulo']);
    }
} 