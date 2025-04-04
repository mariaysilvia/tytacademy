<?php include '../vista/navbarINSTRUCTOR.php'; ?> <!-- Incluye el navbar aquí -->
<body>
    <div id="video-background">
        <video autoplay muted loop>
            <source src="../publico/imagenesinstructor/fonfocreaciondelaspruebas.mp4" type="video/mp4">
        </video>
    </div>
    <section class="form-question">
        <h2>Pruebas TYTACADEMY</h2>
        <form>
            <label for="imagenPreguntas">Imagen de la pregunta:</label>
            <input class="controls" type="file" name="imagenProducto" id="imagenProducto" required>
    
            <label for="nombrespreguntas">Ingrese la pregunta que desea:</label>
            <textarea class="controls" name="nombrespreguntas" id="nombrespreguntas" rows="4" cols="50" placeholder="Ingrese la pregunta." required></textarea>
    
            <div>
                <label for="documento">¿La pregunta tendrá imágenes como respuesta?</label>
                <select class="controls" name="documento" id="documento" required onchange="toggleImageOptions()">
                    <option value="">Elija su respuesta</option>
                    <option value="si">Sí</option>
                    <option value="no">No</option>
                </select>
            </div>
    
            <div id="opciones-container" style="display: none;">  <!-- Inicialmente oculto -->
                <div>
                    <label for="opciones">Ingrese sus múltiples opciones:</label>
                </div>
                <div class="opcion-container">
                    <input type="radio" id="opcionA" name="opciones" value="Opción A">
                    <label for="opcionA">Opción A</label>
                    <textarea id="opcionA-text" rows="2" cols="50" placeholder="Ingrese su opción."></textarea>
                </div>
                <div class="linea"></div>
                <div class="opcion-container">
                    <label for="más">¿Desea agregar más opciones?</label>
                    <a href="#" class="opcion-enlace" onclick="agregarOpcion(); return false;">Más opciones</a>
                </div>
            </div>
    
            <div id="opcionesimagen-container" style="display: none;">  <!-- Inicialmente oculto -->
                <div>
                    <label for="opcionesimagen">Ingrese sus múltiples imágenes:</label>
                </div>
                <div class="opcionimagen-container">
                    <input type="radio" id="imagenA" name="opcionesimagen" value="imagenA">
                    <label for="imagenA">Imagen A</label>
                    <input type="file" id="imagenA-file" accept="image/*" onchange="previewImage(this)">
                    <img id="imagenA-preview" src="#" alt="Vista previa" style="max-width: 100px; max-height: 100px; display: none;">
                </div>
                <div class="linea"></div>
                <div class="opcionimagen-container">
                    <label for="más">¿Desea agregar más opciones?</label>
                    <a href="#" class="opcionimagen-enlace" onclick="agregarImagen(); return false;">Más opciones</a>
                </div>
            </div>
    
            <input class="botons" type="submit" value="Guardar">
            <p><a href="../vista/pruebasINSTRUCTOR.php">¿Desea volver al inicio?</a></p>
        </form>
    </section>
    
    <?php include '../vista/footerINSTRUCTOR.php'; ?> <!-- Incluye el footer aquí -->