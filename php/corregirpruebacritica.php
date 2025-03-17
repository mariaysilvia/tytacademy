<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si todas las preguntas fueron respondidas
    $missingAnswers = false;
    foreach ($_POST as $key => $value) {
        if ($value == "" && strpos($key, "p") === 0) {  // Verifica si hay preguntas sin respuesta
            $missingAnswers = true;
            break;
        }
    }

    // Si faltan respuestas, enviamos un mensaje de error por el localhost
    if ($missingAnswers) {
        echo json_encode(["error" => "Lo siento, debes marcar todas las preguntas"]);
        exit;
    }

    // Definimos las respuestas correctas en un array asociativo
    $respuestasCorrectas = [
        "p1" => 4, "p2" => 4, "p3" => 2, "p4" => 2, "p5" => 1,
        "p6" => 3, "p7" => 3, "p8" => 1, "p9" => 4, "p10" => 1
    ];

    $cantidadAcertadas = 0; // Contador para las respuestas correctas del simulacro
    $preguntasIncorrectas = []; // Array para almacenar las preguntas incorrectas del simulacro

    // Recorremos las respuestas enviadas por el usuario cuando le da en corregir 
    foreach ($respuestasCorrectas as $pregunta => $respuestaCorrecta) {
        if (isset($_POST[$pregunta])) { // Verificamos si la pregunta fue respondida
            $respuestaUsuario = $_POST[$pregunta];

            if ($respuestaUsuario == $respuestaCorrecta) {
                $cantidadAcertadas++; // Suma si la respuesta es correcta
            } else {
                $preguntasIncorrectas[] = $pregunta; // Guarda  si la pregunta es incorrecta
            }
        } else {
            $preguntasIncorrectas[] = $pregunta; // Pregunta no respondida, cuenta como incorrecta ya que estaria en blanco
        }
    }

    // Retornamos la cantidad de aciertos y las preguntas incorrectas en formato JSON para mostrarlos en el html
    echo json_encode([
        "aciertos" => $cantidadAcertadas,
        "incorrectas" => $preguntasIncorrectas
    ]);
}
?>
