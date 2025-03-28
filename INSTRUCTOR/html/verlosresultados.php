<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYT ACADEMY</title>
    <link rel="stylesheet" href="../css/verlosresultados.css">
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
                        <li><a href="../html/inicioinstructor.php"></a></li><!--inicio-->
                        <br>
                        <li><a href="../html/creaciondelaspruebasTYT.php" id="selected">Pruebas</a></li>
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


<div class="recent_order">
    <h2>Recientes pruebas presentadas</h2>
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
          </tr>
        </tbody>
      </table>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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