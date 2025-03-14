
<?php include '../html/navbar.php'; ?> <!-- Incluye el navbar aquí -->


    <!-- Modal para Ver Perfil -->
    <div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="perfilModalLabel">Mi Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="../imagenes/fotoanteojos.jpg" class="rounded-circle" alt="Foto de perfil"
                            style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Nombre:</strong> <span id="perfilNombre" class="dato-perfil"></span></p>
                            <p><strong>Apellido:</strong> <span id="perfilApellido" class="dato-perfil"></span></p>
                            <p><strong>Correo:</strong> <span id="perfilEmail" class="dato-perfil"></span></p>
                            <p><strong>Celular:</strong> <span id="perfilCelular" class="dato-perfil"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnEditar"
                        onclick="habilitarEdicion()">Editar</button>
                    <button type="button" class="btn btn-success" id="btnGuardar" onclick="guardarCambios()"
                        style="display: none;">Guardar</button>
                </div>
            </div>
        </div>
    </div>


</header>

<!--banner de nosotros-->
<section class="bannerGS contenedor">
    <section class="bannerGS_title">
        <h1>Nosotros TYTAcademy</h1> 
        <p>Conoce más acerca de nosotros.</p>
        <br>


    </section>
    <div class="bannerGS_img">
        <img src="../imagenes/mujernosotros.png" alt="">

    </div>
</section>

<!--Informacion adicional-->

<section id="testimonials">
    <div class="container">
    <h1 class="title text-center">Información acerca de las desarrolladoras</h1>
    <br>
    <div class="row offset-1">
        <div class="col-md-5 testimonials">
            <p> 
                Los estudiantes de la ficha 2941294 del programa de Tecnología en Análisis y Desarrollo de Software del SENA CIMM Duitama,
                han creado este sitio web utilizando lenguajes de programación.
                <img src="../imagenes/guadalupe.jpeg" alt="">
                <p class="user-details"><b>Integrante del grupo</b><br>Maria Guadalupe Patiño Perez.</p>
            </p>

        </div>

        <div class="col-md-5 testimonials">
            <p>Los estudiantes de la ficha 2941294 del programa de Tecnología en Análisis y Desarrollo de Software del SENA CIMM Duitama,
                han creado este sitio web utilizando lenguajes de programación.
                <img src="../imagenes/silvia.jpeg" alt="">
                <p class="user-details"><b>Integrante del grupo </b><br>Silvia Daniela Gonzalez Castro</p>
            </p>

        </div>

    </div>


    </div>

</section>

<!--sobre nosotros-->

    <section id="about-us">
        <div class="container">
            <div class="container text-center">
                <h1 class="title">¿Porqué se desarrolló este sitio web?</h1>
                <br>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p>
                        Este sitio web se creó para abordar la dificultad que enfrentan los aprendices al desconocer las pruebas TYT.  Para ello, se ofrecen diversas herramientas, incluyendo simulacros didácticos que ayudan a mejorar el conocimiento y la preparación para estas pruebas.  Además, se incluyen secciones explicativas sobre cada módulo, permitiendo un aprendizaje individualizado.  El objetivo principal es
                        fortalecer el apoyo académico a los aprendices del semna CIMM y facilitar la labor de sus instructores.
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="../imagenes/galeria1.jpg" class="img-fluid">

                </div>

            </div>

        </div>

    </section>
    <br>
    <br>

<!--Apartado de mision, vision y valores (tarjetas y model)-->

<section id="componentes">
    <div class="contenedor">
        <br>
        <br>
        <div class="container text-center">
            <h1 class="title">Nuestra visión, misión y valores.</h1>
        </div>
        <br>
    </div>
    <!-- Misión -->
    <div class="row">
        <div class="col-md-4">
            <div class="card-1">
                <img src="../imagenes/Misión.gif" class="card-img-top" alt="Misión">
                <div class="card-body">
                    <br>
                    <h5>Nuestra Misión</h5>
                    <section class="container my-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#MisionModal">
                            Ver más
                        </button>
                    </section>
    
                    <!-- Modal Misión -->
                    <div class="modal fade" id="MisionModal" tabindex="-1" aria-labelledby="MisionModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="MisionModalLabel">Nuestra Misión</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="modal-text-grande">Empoderar a los estudiantes de preparatoria para que alcancen su máximo potencial en las pruebas TYT,
                                    proporcionándoles una plataforma de preparación integral,
                                    de fácil acceso y con recursos de alta calidad, que fomente el aprendizaje efectivo y la confianza en sí mismos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Visión -->
        <div class="col-md-4">
            <div class="card-2">
                <img src="../imagenes/Visión.gif" class="card-img-top" alt="Visión">
                <div class="card-body">
                    <br>
                    <h5>Nuestra Visión</h5>
                    <section class="container my-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#VisionModal">
                            Ver más
                        </button>
                    </section>
    
                    <!-- Modal Visión -->
                    <div class="modal fade" id="VisionModal" tabindex="-1" aria-labelledby="VisionModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="VisionModalLabel">Nuestra Visión</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="modal-text-grande">Ser la plataforma líder en México para la preparación de las pruebas TYT, reconocida por su enfoque innovador,
                                    contenido actualizado y herramientas interactivas que ayuden a los estudiantes a obtener resultados sobresalientes
                                    y a asegurar su acceso a la educación superior.</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Valores -->
        <div class="col-md-4">
            <div class="card-3">
                <img src="../imagenes/Valores.gif" class="card-img-top" alt="Valores">
                <div class="card-body">
                    <br>
                    <h5>Nuestros Valores</h5>
                    <section class="container my-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ValoresModal">
                            Ver más
                        </button>
                    </section>
    
                    <!-- Modal Valores -->
                    <div class="modal fade" id="ValoresModal" tabindex="-1" aria-labelledby="ValoresModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ValoresModalLabel">Nuestros Valores</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    
                                    <ol class="modal-text-grande">
                                        <li>
                                            <strong>Calidad:</strong> Nos comprometemos a ofrecer productos y servicios que superen las expectativas de nuestros clientes, asegurando altos estándares en cada etapa.
                                        </li>
    
                                        <li>
                                            <strong>Innovación:</strong> Fomentamos un ambiente creativo y dinámico donde las ideas nuevas impulsan nuestro crecimiento y nos permiten adaptarnos a los cambios del mercado.
                                        </li>
                                        <li>
                                            <strong>Sostenibilidad:</strong> Valoramos el cuidado del medio ambiente y asumimos la responsabilidad de minimizar nuestro impacto ecológico, promoviendo prácticas sostenibles en toda la empresa.
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
<br>
<br>    
    <section id="about-us">
        <div class="container">
            <div class="container text-center">
                <h1 class="title">¿Para quienes se desarrolló?</h1>
                <br>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p>Se desarrolló para los aprendices que desean prepararse para presentar su prueba de TYT con cada una de la información que se puede obtener de esta misma y que ellos puedan alimentar su conocimiento. De todas formas, esto ofrece ayuda a los instructores
                    con el fin de facilitar su tarea de enseñanza en las pruebas TYT y así crear una participación de ambas partes.</p>
                </div>
                <div class="col-md-6">
                    <img src="../imagenes/galeria4.png" class="img-fluid1">

                </div>

            </div>

        </div>

    </section>

<!--boton de ir hacia arriba-->

<div id="button-up">
    <i class="fa-solid fa-chevron-up"></i>
</div>

<!--footer-->

<?php include '../html/footer.php'; ?> <!-- Incluye el footer aquí -->