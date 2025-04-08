<?php 
session_start();
if (!isset($_SESSION['instructor'])) {
    header('Location: login.php');
    exit();
}
include 'navbarINSTRUCTOR.php'; 

require_once '../../config/conexion.php';
require_once '../modelo/PreguntaModel.php';

$instructor = $_SESSION['instructor'];
$preguntaModel = new PreguntaModel($pdo);

// Obtener las preguntas del instructor
$idModulo = $instructor['idModulo'];
$preguntas = $preguntaModel->getPreguntasModulo($idModulo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pruebas TYT</title>
    <link rel="stylesheet" href="../publico/css/creaciondelaspruebas.css">
    <style>
        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-img-top {
            max-height: 200px;
            object-fit: contain;
        }
        .pregunta-imagen {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div id="video-background">
        <video autoplay muted loop>
            <source src="../publico/imagenesinstructor/fonfocreaciondelaspruebas.mp4" type="video/mp4">
        </video>
    </div>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Mis Preguntas</h1>
        
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php if (empty($preguntas)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No tienes preguntas creadas todavía. <a href="creaciondelaspruebasTYT.php">Crear una pregunta</a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($preguntas as $pregunta): ?>
                    <div class="col">
                        <div class="card mb-4" style="width: 18rem;" data-pregunta-id="<?php echo $pregunta['idPregunta']; ?>">
                            <?php if (!empty($pregunta['imagen'])): ?>
                                <img src="<?php echo htmlspecialchars($pregunta['imagen']); ?>" class="card-img-top pregunta-imagen" alt="Imagen de la pregunta">
                            <?php endif; ?>
                            
                            <div class="card-body">
                                <h6 class="card-title"><strong>Modulo: </strong><?php echo htmlspecialchars($pregunta['temaModulo']); ?></h6>
                                <p class="card-text"><?php echo htmlspecialchars($pregunta['pregunta']); ?></p>
                            </div>
                            
                            <?php
                            // Obtener las respuestas de la pregunta
                            $respuestas = $preguntaModel->getRespuestasPregunta($pregunta['idPregunta']);
                            if (!empty($respuestas)):
                            ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($respuestas as $respuesta): ?>
                                    <li class="list-group-item <?php echo $respuesta['esCorrecta'] ? 'list-group-item-success' : ''; ?>">
                                        <strong><?php echo $respuesta['esCorrecta'] ? '✓ ' : ''; ?></strong>
                                        <?php echo htmlspecialchars($respuesta['respuesta']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                            
                            <div class="card-body">
                                <a href="editarpregunta.html?id=<?php echo $pregunta['idPregunta']; ?>" class="card-link">Editar</a>
                                <a href="#" class="card-link text-danger" data-eliminar-pregunta="<?php echo $pregunta['idPregunta']; ?>">Eliminar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="../publico/js/verlaspruebasTYT.js"></script>
    <?php include 'footerINSTRUCTOR.php'; ?>
</body>
</html>