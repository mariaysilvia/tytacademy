<?php
require_once 'PruebaModel.php';

class PruebaComunicacionModel extends PruebaModel {
    public function __construct($pdo) {
        parent::__construct($pdo, 'comunicacion');
    }

    protected function obtenerRespuestasCorrectas() {
        // Respuestas correctas para la prueba de comunicación (A=1, B=2, C=3, D=4)
        return [
            1 =>  2, // B
            2 =>  2, // B
            3 =>  3, // C
            4 =>  4, // D
            5 =>  4, // D
            6 =>  3, // C
            7 =>  1, // A
            8 =>  4, // D
            9 =>  4, // D
            10 => 1, // A
            11 => 2, // B
            12 => 1, // A
            13 => 2, // B
            14 => 3, // C
            15 => 2, // B
            16 => 4, // D
            17 => 1, // A
            18 => 4, // D
            19 => 4, // D
            20 => 3  // C
        ];
    }

    protected function guardarResultados($aciertos, $totalPreguntas) {
        // Aquí se implementaría la lógica para guardar los resultados en la base de datos
        // Por ahora es un placeholder
        return true;
    }
} 