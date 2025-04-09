<?php
class InstructorModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function obtenerInstructor($id) {
        $query = "SELECT i.*, m.modulo as nombreModulo 
                 FROM Instructor i 
                 LEFT JOIN Modulo m ON i.idModulo = m.idModulo 
                 WHERE i.idInstructor = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarInstructor($id, $documento, $nombre, $apellido, $email, $clave, $celular, $estado, $idModulo) {
        // Si la clave está vacía, no la actualizamos
        if (empty($clave)) {
            $query = "UPDATE Instructor SET 
                     documento = ?, 
                     nombre = ?, 
                     apellido = ?, 
                     email = ?, 
                     celular = ?, 
                     estado = ?, 
                     idModulo = ? 
                     WHERE idInstructor = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$documento, $nombre, $apellido, $email, $celular, $estado, $idModulo, $id]);
        } else {
            $query = "UPDATE Instructor SET 
                     documento = ?, 
                     nombre = ?, 
                     apellido = ?, 
                     email = ?, 
                     clave = ?, 
                     celular = ?, 
                     estado = ?, 
                     idModulo = ? 
                     WHERE idInstructor = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$documento, $nombre, $apellido, $email, $clave, $celular, $estado, $idModulo, $id]);
        }
    }
}
?> 