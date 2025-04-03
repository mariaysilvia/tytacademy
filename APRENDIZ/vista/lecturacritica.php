<?php include '../vista/navbar.php'; ?> <!-- Incluye el navbar aquí -->

    </header>

    <!--banner de lectura critica-->
<section class="bannerLC contenedor">
    <video autoplay muted loop>
        <source src="../publico/videos/lecturacritica.mp4" type="video/mp4">
    </video>
    <div class="bannerLC-content">
        <section class="bannerLC_title">
            <h1>¡Lectura crítica!</h1>
        </section>
        <div class="bannerLC_img">
            <img src="../publico/imagenes/LogoModuloLecturaCritica.png" alt="">
        </div>
    </div>
</section>
<br>
<br>
<br>


<!--scrollspy de lectura critica-->
<section>
    <div class="row">
        <div class="container text-center">
            <h1 class="title">¿Qué desea conocer?</h1>
        </div>
        <br>
        <div class="col-4">
            <div id="list-example" class="list-groupLC">
                <h3>Responde a tus preguntas</h3>
                <a class="list-groupLC-item list-groupLC-item-action" href="#list-item-1">¿Qué es la lectura critica?</a>
                <a class="list-groupLC-item list-groupLC-item-action" href="#list-item-2">¿Qué se evalua?</a>
                <a class="list-groupLC-item list-groupLC-item-action" href="#list-item-3">¿Cómo son las preguntas?</a>
            </div>
        </div>
        <div class="col-8">
            <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" class="scrollspy-exampleLC" tabindex="0">
                <h4 id="list-item-1">Lectura critica</h4>
                <p>
                <ul>
                    <li>
                        <h5>Lectura:</h5>Pasar la vista por los signos de una palabra o texto escrito para interpretarlos mentalmente o en voz alta.
                    </li>
                    <li>
                        <h5>Critica:</h5>Conjunto de opiniones o juicios que responden a un análisis ya sea positivo o negativo.
                    </li>
                </ul>
                En términos generales, la lectura crítica permite a la persona que lee ser más reflexiva y activa.
                De esta manera, se logra una comprensión de lectura exitosa, ya que adquirir un análisis profundo
                requiere dedicación y una buena rutina de lectura.
                </p>
                <h4 id="list-item-2">Evaluando</h4>
                <p>Evalúa habilidades para comprender, interpretar y evaluar textos que pueden encontrarse en la vida cotidiana y
                en ambitos académicos no especializados.
                <ul>
                    <li>Significado de las frases o palabras vistas en los textos durante las pruebas.</li>
                    <li>Fragmentos cortas para generar un sentido global.</li>
                    <li>Reflexión y evaluación con respecto a los diferentes textos que se van a desarrollar.</li>
                    <li>Tener en cuenta los niveles de lectura para el analisis correcto de las lecturas.</li>
                </ul>
                </p>
                <h4 id="list-item-3">Tipo de preguntas</h4>
                <p>Las preguntas presentadas en este modulo son de selección multiple con unica respuesta:
                <img src="../publico/imagenes/unicarespuesta.png" alt=""><br>
                Se podria decir que la forma de contestarlas es mediante un cuadernillo de respuestas señalando una sola:
                <img src="../publico/imagenes/respuestaunica.png" alt="">
                </p>
            </div>
        </div>
    </div>
</section>
<br>
<br>

    <!--textos continuos y discontinuos-->
    <div class="container text-center">
        <h1 class="title">¿Textos continuos y discontinuos?</h1>
    </div>
    
    <div class="containerLC-cards"> 
        <div class="cardLC" style="width: 550px; height: 400px;">
            <div class="face front">
                <img src="../publico/imagenes/Discontinuos.gif" alt="">
                <h3>Tipos de textos</h3>
            </div>
            <div class="face back">
                <h3>Discontinuos</h3>
                <p>Estos textos no se basan en la estructura tradicional de oraciones y párrafos, sino que utilizan elementos visuales como
                imágenes, gráficos, tablas y símbolos para transmitir información.</p>
                <p><strong>En las pruebas TYT, puedes encontrarlos en forma de infografías, gráficos, cómics y tablas.</strong></p>
                <div class="link">
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="cardLC" style="width: 550px; height: 400px;">
            <div class="face front">
                <img src="../publico/imagenes/Continuos.gif" alt="">
                <h3>Tipos de textos</h3>
            </div>
            <div class="face back">
                <h3>Continuos</h3>
                <p>Se organizan en oraciones y párrafos que se conectan entre sí, creando un discurso lógico y fluido.
                Su principal herramienta es el lenguaje escrito,
                utilizando reglas gramaticales para que la información se entienda de forma clara y coherente.</p>
                    <p><strong>En las pruebas TYT, puedes encontrar ejemplos de textos continuos en forma de ensayos, novelas y artículos de prensa.</strong></p>
                <div class="link">
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    
    <!--niveles de lectura-->
    <div class="container text-center">
        <h1 class="title">Niveles de lectura</h1>
    </div>
    <div class="elements-container">

        <div class="element element--blue">
            <i class="fa-solid fa-file-lines"></i>
        <h3>Lectura Literal</h3>
        <p>
            Este nivel busca la comprensión básica del texto, centrándose en la información explícita y el significado de las palabras y frases.
        </p>
        </div>

        <div class="element element--purple">
            <i class="fa-solid fa-book-open-reader"></i>
        <h3>Lectura Inferencial</h3>
        <p>
            Este nivel busca que el lector vaya más allá de la información explícita, realizando deducciones e inferencias basadas en el texto.
        </p>
        </div>

        <div class="element element--brown">
            <i class="fa-solid fa-address-book"></i>
        <h3>Lectura Crítica</h3>
        <p>
            Este nivel implica una evaluación y análisis profundo del texto, considerando las intenciones del autor y la validez de sus argumentos. Esto genera un proceso reflexivo que involucra juicios y opiniones.
        </p>
        </div>
    

<!-- TipsCarrusel de imagenes-->
<section id="carrusel" class="container my-5">
    <div class="container text-center">
        <h1 class="title">Tips para mejorar tu lectura</h1>
    </div>
    <br>
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="../publico/imagenes/consejo1.png" class="d-block w-53 mx-auto" alt="1">
        </div>
        <div class="carousel-item">
            <img src="../publico/imagenes/consejo2.png" class="d-block w-53 mx-auto" alt="2">
        </div>
        <div class="carousel-item">
            <img src="../publico/imagenes/consejo3.png" class="d-block w-53 mx-auto" alt="3">
        </div>
        <div class="carousel-item">
            <img src="../publico/imagenes/consejo4.png" class="d-block w-53 mx-auto" alt="4">
        </div>
        <div class="carousel-item">
            <img src="../publico/imagenes/consejo5.png" class="d-block w-53 mx-auto" alt="5">
        </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-primary" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-primary" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>



<!--boton de ir hacia arriba-->

<div id="button-up">
    <i class="fa-solid fa-chevron-up"></i>
</div>

<?php include '../vista/footer.php'; ?> <!-- Incluye el footer aquí -->