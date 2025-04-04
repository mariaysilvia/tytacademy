<?php
/**
 * Clase AprendizModel
 * Maneja todas las operaciones relacionadas con los aprendices en la base de datos
 */
class AprendizModel {
    private $pdo;
    
    /**
     * Constructor de la clase
     * @param PDO $pdo Conexión a la base de datos
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Obtiene todos los aprendices de la base de datos
     * @return array Lista de aprendices
     */
    public function obtenerAprendices() {
        $sql = "SELECT idAprendiz, documento, nombres, apellidos, correo, contraseña AS clave, celular FROM Aprendiz";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Verifica si hay aprendices en la base de datos
     * @return bool True si hay aprendices, false si no
     */
    public function hayAprendices() {
        $sql = "SELECT COUNT(*) FROM Aprendiz";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
} 