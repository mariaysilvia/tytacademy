<?php
//Clase AprendizModel
//Maneja todas las operaciones relacionadas con los aprendices en la base de datos,
//incluyendo consulta y validación de datos de aprendices.
class AprendizModel {
    //Instancia de conexión a la base de datos
    private $pdo;
    
    //Constructor de la clase lo cual la inicializa
    //@param PDO $pdo Conexión a la base de datos
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    //Obtiene todos los aprendices de la base de datos
    //Lista de aprendices con todos  sus datos
    public function obtenerAprendices() {
        $sql = "SELECT idAprendiz, documento, nombres, apellidos, correo, contraseña AS clave, celular FROM Aprendiz";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Verifica si hay aprendices en la base de datos
    // True si hay aprendices, False si no hay ninguno
    public function hayAprendices() {
        $sql = "SELECT COUNT(*) FROM Aprendiz";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
} 