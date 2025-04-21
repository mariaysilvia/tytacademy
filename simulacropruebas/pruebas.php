<?php
session_start();

// Validación: si no hay preguntas, redirige
if (!isset($_SESSION['preguntas']) || empty($_SESSION['preguntas'])) {
    header('Location: /trabajos/PruebasTYT/APRENDIZ/vista/PRUEBAS.php?error=No hay preguntas disponibles');
    exit;
}

// Obtener las preguntas de la sesión
$preguntas = $_SESSION['preguntas'];

// Obtener el módulo o tema seleccionado (opcional, si deseas mostrarlo)
$moduloId = $_SESSION['modulo_id'] ?? 'Desconocido';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba TYT</title>
    <link rel="stylesheet" href="/trabajos/PruebasTYT/APRENDIZ/publico/css/principalAprendiz.css">
    <link rel="stylesheet" href="/trabajos/PruebasTYT/simulacropruebas/PRUEBASestilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-prueba">
        <header class="header-prueba">
            <h1 id="tituloPrueba">Prueba TYT</h1>
        </header>

        <main class="contenedor-preguntas">
            <form id="formRespuestas">
                <div id="preguntas">
                    <?php
                    $contadorPreguntas = 1;

                    foreach ($preguntas as $grupo) {
                        // Agrupadas por imagen
                        if (isset($grupo['preguntas'])) {
                            echo '<div class="grupo-preguntas">';
                            if (!empty($grupo['imagen'])) {
                                echo '<div class="imagen-grupo"><img src="' . htmlspecialchars($grupo['imagen']) . '" alt="Imagen del grupo"></div>';
                            }

                            foreach ($grupo['preguntas'] as $pregunta) {
                                echo '<div class="pregunta">';
                                echo '<h3>Pregunta ' . $contadorPreguntas . '</h3>';
                                echo '<p>' . htmlspecialchars($pregunta['pregunta']) . '</p>';
                                echo '<div class="opciones-vertical">';
                                foreach ($pregunta['respuestas'] as $respuesta) {
                                    echo '<label class="opcion">';
                                    echo '<input type="radio" name="respuesta_' . $pregunta['id'] . '" value="' . $respuesta['id'] . '" required>';
                                    echo '<span>' . htmlspecialchars($respuesta['texto']) . '</span>';
                                    if (!empty($respuesta['imagen'])) {
                                        echo '<img src="' . htmlspecialchars($respuesta['imagen']) . '" alt="Imagen de respuesta" class="imagen-respuesta">';
                                    }
                                    echo '</label>';
                                }
                                echo '</div></div>';
                                $contadorPreguntas++;
                            }

                            echo '</div>'; // Cierre de grupo
                        }
                        // Pregunta individual (sin grupo)
                        else {
                            echo '<div class="pregunta">';
                            echo '<h3>Pregunta ' . $contadorPreguntas . '</h3>';
                            if (!empty($grupo['imagen'])) {
                                echo '<div class="imagen-pregunta"><img src="' . htmlspecialchars($grupo['imagen']) . '" alt="Imagen de la pregunta"></div>';
                            }
                            echo '<p>' . htmlspecialchars($grupo['pregunta']) . '</p>';
                            echo '<div class="opciones-vertical">';
                            foreach ($grupo['respuestas'] as $respuesta) {
                                echo '<label class="opcion">';
                                echo '<input type="radio" name="respuesta_' . $grupo['id'] . '" value="' . $respuesta['id'] . '" required>';
                                echo '<span>' . htmlspecialchars($respuesta['texto']) . '</span>';
                                if (!empty($respuesta['imagen'])) {
                                    echo '<img src="' . htmlspecialchars($respuesta['imagen']) . '" alt="Imagen de respuesta" class="imagen-respuesta">';
                                }
                                echo '</label>';
                            }
                            echo '</div></div>';
                            $contadorPreguntas++;
                        }
                    }
                    ?>
                </div>
            </form>
        </main>

        <!-- Botón finalizar -->
        <div class="finalizar-prueba">
            <button id="btnFinalizar" class="btn-finalizar">Finalizar Prueba</button>
        </div>
    </div>

    <!-- Tarjeta de resultados -->
    <div id="tarjetaResultados" class="tarjeta-oculta">
        <div class="contenido-tarjeta">
            <span id="emojiResultado" style="font-size: 2rem;"></span>
            <h3>¡Resultados!</h3>
            <p id="resCorrectas"></p>
            <p id="resIncorrectas"></p>
            <button onclick="cerrarTarjeta()">Cerrar</button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/trabajos/PruebasTYT/APRENDIZ/publico/js/cargartemas.js"></script>
    <script src="/trabajos/PruebasTYT/APRENDIZ/publico/js/corregirpruebas.js"></script>
</body>
</html>