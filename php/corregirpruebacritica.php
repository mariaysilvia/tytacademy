<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "basededatostytacademy");
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Reiniciar todas las respuestas a incorrectas
    $conn->query("UPDATE Respuesta SET esCorrecta = FALSE");

    // Respuestas correctas con su rango completo (20 preguntas)
    $respuestasCorrectas = [
        // Preguntas 1-10
        ["idPregunta" => 1, "idRespuesta" => 4],
        ["idPregunta" => 2, "idRespuesta" => 4],
        ["idPregunta" => 3, "idRespuesta" => 2],
        ["idPregunta" => 4, "idRespuesta" => 2],
        ["idPregunta" => 5, "idRespuesta" => 1],
        ["idPregunta" => 6, "idRespuesta" => 3],
        ["idPregunta" => 7, "idRespuesta" => 3],
        ["idPregunta" => 8, "idRespuesta" => 1],
        ["idPregunta" => 9, "idRespuesta" => 4],
        ["idPregunta" => 10, "idRespuesta" => 1],
        
        // Preguntas 11-20
        ["idPregunta" => 11, "idRespuesta" => 3],
        ["idPregunta" => 12, "idRespuesta" => 2],
        ["idPregunta" => 13, "idRespuesta" => 2],
        ["idPregunta" => 14, "idRespuesta" => 4],
        ["idPregunta" => 15, "idRespuesta" => 1],
        ["idPregunta" => 16, "idRespuesta" => 2],
        ["idPregunta" => 17, "idRespuesta" => 4],
        ["idPregunta" => 18, "idRespuesta" => 2],
        ["idPregunta" => 19, "idRespuesta" => 2],
        ["idPregunta" => 20, "idRespuesta" => 3],
    ];

    // Actualizar las respuestas correctas en la base de datos
    foreach ($respuestasCorrectas as $respuesta) {
        $idPregunta = $respuesta["idPregunta"];
        $idRespuesta = $respuesta["idRespuesta"];
        $conn->query("UPDATE Respuesta SET esCorrecta = TRUE WHERE idPregunta = $idPregunta AND idRespuesta = $idRespuesta");
    }

    // Crear un mapa de respuestas correctas
    $respuestasCorrectasMap = [];
    foreach ($respuestasCorrectas as $respuesta) {
        $respuestasCorrectasMap["p" . $respuesta["idPregunta"]] = $respuesta["idRespuesta"];
    }

    // Decodificar las respuestas enviadas por el cliente
    $respuestasUsuario = json_decode(file_get_contents("php://input"), true);

    // Validar que se hayan respondido las 20 preguntas
    if (!$respuestasUsuario || count($respuestasUsuario) != 20) {
        echo json_encode(["error" => "Debes responder exactamente 20 preguntas."]);
        exit;
    }

    $cantidadAcertadas = 0;
    $preguntasIncorrectas = [];
    $respuestasConEstado = [];

    foreach ($respuestasUsuario as $respuesta) {
        $pregunta = $respuesta["pregunta"];
        $respuestaUsuario = $respuesta["respuestaUsuario"];

        // Extraer el número de pregunta
        $numeroPregunta = substr($pregunta, 1);

        // Verificar si la pregunta está en el rango de 1 a 20
        if ($numeroPregunta >= 1 && $numeroPregunta <= 20) {
            $esCorrecta = ($respuestaUsuario !== null && $respuestaUsuario == $respuestasCorrectasMap[$pregunta]);

            if ($esCorrecta) {
                $cantidadAcertadas++;
            } else {
                $preguntasIncorrectas[] = $pregunta;
            }

            $respuestasConEstado[] = [
                "pregunta" => $pregunta,
                "respuestaUsuario" => $respuestaUsuario,
                "esCorrecta" => $esCorrecta
            ];
        } else {
            // Manejar preguntas fuera del rango
            $preguntasIncorrectas[] = $pregunta;
            $respuestasConEstado[] = [
                "pregunta" => $pregunta,
                "respuestaUsuario" => $respuestaUsuario,
                "esCorrecta" => false
            ];
        }
    }

    $conn->close();

    echo json_encode([
        "aciertos" => $cantidadAcertadas,
        "incorrectas" => $preguntasIncorrectas,
        "respuestas" => $respuestasConEstado
    ]);
}
?>