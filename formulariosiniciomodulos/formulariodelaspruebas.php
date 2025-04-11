<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYT ACADEMY</title>
    <link rel="stylesheet" href="formulariosparamodulos.css">
    <link rel="icon" href="imagenesVideos/lecturacriticamodulo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="/trabajos/PruebasTYT/APRENDIZ/publico/js/cargartemas.js"></script>
</head>
<body>
    <div id="video-background">
        <video autoplay muted loop>
            <source src="imagenesVideos/CRITICA.mp4" type="video/mp4">
        </video>
    </div>
    <section class="form-register">
        <img src="imagenesVideos/tytacademy.png" alt="TYTAcademy">
        <h2>¿Quieres prepararte para las pruebas TYT?</h2>
        <h5>¡Realiza los simulacros de cada modulo!</h5>
        <h4>Escoge los temas y la cantidad de preguntas <strong> ¡Animo!</strong></h4>
        <br>
        <h6>Define las caracteristicas de la prueba</h6>
        <form id="formPrueba" action="/trabajos/PruebasTYT/APRENDIZ/controlador/realizarPrueba.php" method="GET">
            <input type="hidden" name="tipoPrueba" id="tipoPrueba" value="">
            <label for="temaModulo">¿Qué temas desea practicar?:</label>
            <select class="controls" name="temaModulo" id="temaModulo" required>
                <option value="">Cargando temas...</option>
            </select>
            <label for="cantidad">¿Cuántas preguntas desea realizar?:</label>
            <select class="controls" name="cantidad" id="cantidad" required>
                <option value="5">5 preguntas</option>
                <option value="10">10 preguntas</option>
                <option value="15">15 preguntas</option>
                <option value="20">20 preguntas</option>
            </select>
            <input class="botons" type="submit" value="Realizar Prueba">
            <p><a href="../../APRENDIZ/vista/PRUEBAS.php">Cambiar de modulo</a></p>
        </form>
    </section>
    <?php include 'footerFORMULARIOS.php'; ?>
    <!-- codigo js -->
<script src="/trabajos/PruebasTYT/APRENDIZ/publico/js/cargartemas.js"></script>
</body>

</body>
</html>