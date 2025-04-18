<?php 
session_start();
if (!isset($_SESSION['instructor'])) {
    header('Location: login.php');
    exit();
}
include 'navbarINSTRUCTOR.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de Preguntas</title>
    <link rel="stylesheet" href="../publico/css/creaciondelaspruebas.css">
</head>
<body>
    <div id="video-background">
        <video autoplay muted loop>
            <source src="../publico/imagenesinstructor/fonfocreaciondelaspruebas.mp4" type="video/mp4">
        </video>
    </div>

    <div id="mensaje" class="mensaje" style="display: none;"></div>

    <div class="container">
        <h1>Creación de Preguntas</h1>
        
        <form id="formPregunta" enctype="multipart/form-data">
            <div class="form-group">
                <label for="idtipoPregunta">Tipo de Pregunta:</label>
                <select id="idtipoPregunta" name="idtipoPregunta" required>
                    <option value="">Seleccione un tipo</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="idtemaModulo">Tema del Módulo:</label>
                <select id="idtemaModulo" name="idtemaModulo" required>
                    <option value="">Seleccione un tema</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="pregunta">Pregunta:</label>
                <textarea id="pregunta" name="pregunta" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="imagenPregunta">Imagen de la Pregunta (opcional):</label>
                <input type="file" id="imagenPregunta" name="imagenPregunta" accept="image/*">
            </div>
            
            <div class="form-group">
                <label>Opciones de Respuesta:</label>
                <div id="opciones-container">
                    <div class="opcion-container">
                        <input type="radio" id="opcionA" name="opciones" value="Opción A">
                        <label for="opcionA">Opción A</label>
                        <textarea id="opcionA-text" rows="2" cols="50" placeholder="Ingrese su opción."></textarea>
                    </div>
                    <div class="opcion-container">
                        <input type="radio" id="opcionB" name="opciones" value="Opción B">
                        <label for="opcionB">Opción B</label>
                        <textarea id="opcionB-text" rows="2" cols="50" placeholder="Ingrese su opción."></textarea>
                    </div>
                    <div class="opcion-container">
                        <input type="radio" id="opcionC" name="opciones" value="Opción C">
                        <label for="opcionC">Opción C</label>
                        <textarea id="opcionC-text" rows="2" cols="50" placeholder="Ingrese su opción."></textarea>
                    </div>
                    <div class="opcion-container">
                        <input type="radio" id="opcionD" name="opciones" value="Opción D">
                        <label for="opcionD">Opción D</label>
                        <textarea id="opcionD-text" rows="2" cols="50" placeholder="Ingrese su opción."></textarea>
                    </div>
                    <div class="linea"></div>
                    <div class="opcion-container">
                        <label for="más">¿Desea agregar más opciones?</label>
                        <a href="#" class="opcion-enlace" onclick="agregarOpcion(); return false;">Más opciones</a>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit">Guardar Pregunta</button>
            </div>
        </form>
    </div>
    
    <script src="../publico/js/opcionesdelaspruebas.js"></script>
    <script src="../publico/js/creacionpreguntas.js"></script>
</body>
</html>