<?php include '../vista/navbar.php'; ?> <!-- Incluye el navbar aquí -->


<!--banner-->
<section class="bannerES contenedor">
<section class="bannerES_title">
    <h1>¡Bienvenido, estudiante! </h1> 
    <p>Conoce más acerca de lo que puedes hacer en este sitio web.</p>
    <br>


</section>
<div class="bannerES_img">
    <img src="../publico/imagenes/banner-inicio.png" alt="">

</div>
</section>


<!--informacion-->
<br>
<br>
<section id="informacion">
    <div class="container text-center">
        <h1 class="title">¿Cómo desea iniciar?</h1>
    </div>
    <div class="columna1">
        <div class="contenedor-1">
            <div class="columna-1">
                <h1>Guía para Estudiar Cada Módulo.</h1>
                <br>
                <p>
                    En este apartado te guiaremos a través de los temas que pueden aparecer en las pruebas de cada
                    módulo, te explicaremos el tipo de preguntas que encontrarás y, lo más importante,
                    te daremos consejos para que puedas estudiar de forma efectiva.
                <ul>
                    <li>Lectura Crítica</li>
                    <li>Razonamiento Cuantitativo</li>
                    <li>Competencias Ciudadanas</li>
                    <li>Comunicación Escrita</li>
                    <li>Inglés</li>
                </ul>
                </p>
            </div>

        </div>
        <img class="imagen1" src="../publico/imagenes/modulosTYTimagen.jpg" alt="">
    </div>


    <div class="columna2">
        <div class="contenedor-2">
            <div class="columna-2">
                <h1>Domina la Prueba TYT: ¡Practica Ahora!</h1>
                <br>
                <p>
                    En este apartado podrás acceder a distintos formularios de acuerdo al módulo que escogiste. Estos
                    formularios contienen preguntas aleatorias proporcionadas
                    por los distintos instructores de esa respectiva área.
                </p>
                <p>
                    Gracias a esto, puedes ir preparado para la prueba, ya sea en la duración de cada pregunta, en las
                    alternativas que
                    puedes hacer durante la prueba TYT y, sobre todo, reconociendo cada una de tus falencias para ir
                    mejorando cada vez más en tu rendimiento para la prueba real.
                </p>
                <a href="../vista/PRUEBAS.php" class="botones">Ver más</a>
            </div>

        </div>
        <img class="imagen2" src="../publico/imagenes/pruebasTyt.jpg" alt="">
    </div>

    <div class="columna3">
        <div class="contenedor-3">
            <div class="columna-3">
                <h1>Sobre Nosotros</h1>
                <br>
                <p>
                    En esta sección podrás conocer a los creadores de este sitio web, su misión, visión y valores.
                    Esto te permitirá comprender mejor la filosofía detrás de este proyecto y la ayuda que se busca
                    ofrecer a los estudiantes.

                </p>
                <p>
                    Podrás descubrir las motivaciones de los autores y la pasión que los impulsa a crear este espacio de
                    aprendizaje.
                </p>
                <a href="../vista/nosotros.php" class="botones">Ver más</a>

            </div>

        </div>
        <img class="imagen3" src="../publico/imagenes/nosotrostyt.jpg" alt="">
    </div>

    <div class="columna4">
        <div class="columna-4">
            <h1>Configuración de Perfil</h1>
            <br>
            <p>
                En este apartado podrás visualizar tu perfil de usuario dentro del sitio web, donde tendrás la opción de editar, eliminar e incluso cambiar tu foto.
            </p>
            <p>
                Gracias a esto, podrás llevar un control de tu progreso, así como de los formularios que ya has presentado y otras opciones disponibles en esta sección.
            </p>
            <a href="#" class="botones">Ver más</a>
    
        </div>
        <img class="imagen4" src="../publico/imagenes/perfiltyt.jpg" alt="">
    </div>


</section>


<!--video-->
<section>
<div class="video-container">
    <h2 class="video-title">¿Cómo funciona?</h2>
    <video width="800" height="450" controls>
        <source src="../publico/videos/explicatyt.mp4" type="video/mp4">

    </video>
</div>
</section>


<!--boton de ir hacia arriba-->

<div id="button-up">
<i class="fa-solid fa-chevron-up"></i>
</div>

<?php include '../vista/footer.php'; ?> <!-- Incluye el footer aquí -->

<script></script>
</body>
</html>