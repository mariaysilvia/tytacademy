<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYT ACADEMY</title>
    <link rel="stylesheet" href="../css/inicioinstructor.css">
    <link rel="icon" href="../imagenesinstructor/computador.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<header>
        <div class="header_superior">
            <div class="logo"> 
                <img src="../imagenesinstructor/tytacademy.png" alt="TYT Academy Logo">
            </div>
        </div>
        <div class="container_menu">
            <div class="menu">
                <nav>
                    <ul>
                        <li><a href="#" id="selected"></a></li><!--inicio-->
                        <br>
                        <li><a href="../html/pruebasINSTRUCTOR.php">Pruebas</a></li>
                        <li><a href="#" onclick="abrirModal()">Mi perfil</a>
                            <ul>
                                <li><a href="#" onclick="abrirModal()">Ver perfil</a></li>
                                <li><a href="#">Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        
        <!-- Modal para Ver Perfil -->
<!-- Modal para Ver Perfil -->
<div class="modal fade" id="verPerfilModal" tabindex="-1" aria-labelledby="verPerfilModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verPerfilModalLabel">Mi Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img src="../imagenes/fotoanteojos.jpg" class="rounded-circle" alt="Foto de perfil" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p><strong>Nombre:</strong> <span id="perfilNombre" class="dato-perfil"></span></p>
                        <p><strong>Apellido:</strong> <span id="perfilApellido" class="dato-perfil"></span></p>
                        <p><strong>Correo:</strong> <span id="perfilEmail" class="dato-perfil"></span></p>
                        <p><strong>Contraseña:</strong> <span id="perfilRol" class="dato-perfil"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnEditar" onclick="habilitarEdicion()">Editar</button>
                <button type="button" class="btn btn-success" id="btnGuardar" onclick="guardarCambios()" style="display: none;">Guardar</button>
            </div>
        </div>
    </div>
</div>


        
        <script>
            function abrirModal() {
                var myModal = new bootstrap.Modal(document.getElementById('verPerfilModal'));
                myModal.show();
            }
        </script>
        
</header>

<!--banner instructor-->
<section class="bannerING contenedor">
    <section class="bannerING_title">
        <h1>¡Bienvenido, instructor! </h1> 
        <p>Conoce más acerca de lo que puedes hacer dentro de nuestro sitio web.</p>
        <br>


    </section>
    <div class="bannerING_img">
        <img src="../imagenesinstructor/bannerprofesor.png" alt="">

    </div>
</section>

<!--informacion de la prueba tyt-->
<br>
<br>
<br>
<section id="informacion">
    <div class="container text-center">
        <h1 class="title">¿Qué podrá hacer en TYTACADEMY?</h1>
    </div>
    <div class="columna1ING">
        <div class="contenedor-1ING">
            <div class="columna-1ING">
                <h1>Genere las preguntas de su módulo.</h1>
                <br>
                <p>
                    Como instructor podra ejercer la función de generar preguntas para los módulos de las pruebas TYT, adjunte sus imagenes, adjunte cual es 
                    la opción correcta e incorrecta y ayude a sus aprendices a mejorar su plan de estudio para las pruebas TYT.
                    <ul class="lista">
                        <h4>Estos son todos los módulos que tiene la prueba: </h4>
                        <li>Lectura Crítica</li>
                        <li>Razonamiento Cuantitativo</li>
                        <li>Competencias Ciudadanas</li>
                        <li>Comunicación Escrita</li>
                        <li>Inglés</li>
                    </ul>
                </p>
            </div>
            
        </div>
        <img class="imagen1ING" src="../imagenesinstructor/enseñanza.jpg" alt="">
    </div>
</section>
<br>
<!--video-->
<section>
    <div class="videoING-container">
        <h2 class="videoING-title">¿Cómo funciona?</h2>
        <video width="800" height="450" controls>
            <source src="../imagenesinstructor/videoinstructores.mp4" type="video/mp4">
    
        </video>
    </div>
    </section>
<br>
<br>
<br>
    <!--Pasos para seguir y registrar su pregunta-->
    <div class="container text-center">
        <h1 class="title">¿Qué puede hacer?</h1>
    </div>
    <div class="elements-containerING">

        <div class="elementING elementING--blue">
            <i class="fa-solid fa-file"></i>
        <h3>Ingrese a "Pruebas".</h3>
        <p>
            En este menú encontrará el apartado en cual podra ingresar, eliminar y modificar los formularios del modulo que le corresponda.
        </p>
        </div>

        <div class="elementING elementING--purple">
            <i class="fa-solid fa-eye"></i>
        <h3>Visualice las opciones del apartado del modulo.</h3>
        <p>
            Haga la lectura correspondiente de la información del módulo que le corresponda, para que pueda generar preguntas acorde a la información.
        </p>
        </div>

        <div class="elementING elementING--brown">
            <i class="fa-solid fa-pen-to-square"></i>
        <h3>Registre, elimine y modifique cada formulario que vea correspondiente.</h3>
        <p>
            Registre las preguntas que considere necesarias para el módulo, elimine las que considere que no son necesarias y modifique las que considere que no estan bien.
        </p>
        </div>

        <div class="elementING elementING--green">
            <i class="fa-solid fa-upload"></i>
        <h3>Suba el contenido y ayude a preparse a los estudiantes.</h3>
        <p>
            Suba el contenido para que los estudiantes puedan prepararse de la mejor manera para la prueba TYT, tenga en cuenta que dichos formularios se podrán presentar
            en modo de practica para los estudiantes.
        </p>
        </div>


<!--Texto adicional-->
<div class="columna2ING">
    <div class="contenedor-2ING">
        <div class="columna-2ING">
            <h1>¡Empiece a elaborar las pruebas!</h1>
            <br>
            <p>
                Inicia ahora el proceso de creación de preguntas para los módulos de las pruebas TYT. Además, podrás visualizar los resultados de los simulacros que los estudiantes realicen, permitiéndote ajustar y mejorar el contenido según sus necesidades.
            </p>
            <p>
                Tu labor como instructor es crucial para ayudar a los estudiantes a mejorar su desempeño y obtener mejores resultados en las pruebas TYT. ¡Comienza a instruir y a hacer la diferencia!
            </p>
        </div>
    </div>
    <img class="imagen2ING" src="../imagenesinstructor/instruccion.jpg" alt="Instructor enseñando">
</div>





<!--boton de ir hacia arriba-->

<div id="button-up">
    <i class="fa-solid fa-chevron-up"></i>
</div>


<!--footer-->

<footer class="footer-distributed">
    <div class="footer-left">
        <div class="logo">
            <img src="../imagenesinstructor/tytacademy.png" alt="TYTAcademy">
        </div>
        <p class="footer-links">
            <a href="#">Inicio</a>
            |
            <a href="#">Nosotros</a>
            |
            <a href="#">Contactos</a>
            |
            <a href="#">SENA</a>
        </p>

        <p class="footer-company-name">Copyright 2025 <strong> TYTACADEMY </strong> Derechos reservados</p>

    </div>
    <div class="footer-center">

        <div>
            <i class="fa-solid fa-location-dot"></i>
            <p><span>SENA</span>CIMM</p>
        </div>

        <div>
            <i class="fa fa-phone"></i>
            <p>3206831437 </p> | <p> 3132630302</p>
        </div>

        <div>
            <i class="fa fa-envelope"></i><!--correo tyt-->
            <p><a href="mailto:tytacademy28@gmail.com">tytacademy28@gmail.com</a></p>
        </div>
    </div>

    <div class="footer-right">
        <p class="footer-company-about">
            <span>Sobre el sitio web.</span>
            <strong>TYT ACADEMY</strong> Estudia para las pruebas TYT de manera rapida y efectiva.
        <p>Simulacros aleatorios que te ayudan a un mejor desempeño para el resultado que tanto aspiras a obtener.
        </p>
        <div class="footer-icons">
            <a href="https://www.instagram.com/tytacademy28/?next=%2F" target="_blank"><i
                    class="fa-brands fa-instagram"></i></a>
            <a href="https://x.com/AcademyTyt28" target="_blank"><i class="fa-brands fa-twitter"></i></a>
        </div>
    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="../js/botonarriba.js"></script>
<script>
    async function abrirModal() {
        const modal = new bootstrap.Modal(document.getElementById('perfilModal'));
        const resultado = await cargarDatosPerfil();

        if (resultado.success && resultado.data) {
            document.getElementById('perfilNombre').textContent = resultado.data.nombres;
            document.getElementById('perfilApellido').textContent = resultado.data.apellidos;
            document.getElementById('perfilEmail').textContent = resultado.data.correo;
            document.getElementById('perfilCelular').textContent = resultado.data.celular;
            modal.show();
        } else {
            alert('Error al cargar los datos del perfil');
        }
    }

    function confirmarCerrarSesion() {
        if (confirm('¿Está seguro de que desea cerrar la sesión?')) {
            alert('Sesión cerrada exitosamente');
            window.location.href = 'registro.html';
        }
    }
</script>


</body>

</html>

