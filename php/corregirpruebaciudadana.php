<?php
// Activar reporting de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establecer encabezados JSON de manera estricta
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

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

    // Respuestas correctas (A=1, B=2, C=3, D=4)
    $respuestasCorrectas = [
        1 =>  3, // C
        2 =>  2, // B
        3 =>  4, // D
        4 =>  1, // A
        5 =>  4, // D
        6 =>  4, // D
        7 =>  1, // A
        8 =>  1, // A
        9 =>  4, // D
        10 => 4, // D
        11 => 4, // D
        12 => 3, // C
        13 => 4, // D
        14 => 2, // B
        15 => 4, // D
        16 => 1, // A
        17 => 1, // A
        18 => 4, // D
        19 => 3, // C
        20 => 1  // A
    ];

    $aciertos = 0;
    $incorrectas = [];
    $respuestasDetalladas = [];

    // Comparar respuestas
    foreach ($respuestasUsuario as $idPregunta => $idRespuestaUsuario) {
        // Verificar si existe respuesta correcta para esta pregunta
        if (isset($respuestasCorrectas[$idPregunta])) {
            $idRespuestaCorrecta = $respuestasCorrectas[$idPregunta];
            $esCorrecta = ($idRespuestaUsuario == $idRespuestaCorrecta);

            if ($esCorrecta) {
                $aciertos++;
            } else {
                $incorrectas[] = $idPregunta;
            }

            $respuestasDetalladas[] = [
                "id_pregunta" => $idPregunta,
                "respuesta_usuario" => $idRespuestaUsuario,
                "respuesta_correcta" => $idRespuestaCorrecta,
                "es_correcta" => $esCorrecta
            ];
        }
    }

    // Respuesta JSON
    echo json_encode([
        "aciertos" => $aciertos,
        "total_preguntas" => count($respuestasUsuario),
        "incorrectas" => $incorrectas,
        "respuestas" => $respuestasDetalladas
    ]);
    exit;

} catch (Exception $e) {
    // Enviar error como JSON
    echo json_encode([
        'error' => $e->getMessage()
    ]);
    exit;
}
?>