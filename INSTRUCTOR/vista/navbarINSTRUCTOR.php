<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYT ACADEMY</title>
    <link rel="stylesheet" href="../publico/css/inicioinstructor.css">
    <link rel="stylesheet" href="../publico/css/pruebasINSTRUCTOR.css">
    <link rel="stylesheet" href="../publico/css/creaciondelaspruebas.css">
    <link rel="stylesheet" href="../publico/css/verlaspruebasTYT.css">
    <link rel="stylesheet" href="../publico/css/verlosresultados.css">
    <link rel="icon" href="../publico/imagenesinstructor/computador.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<header>
    <div class="header_superior">
        <div class="logo"> 
            <img src="../publico/imagenesinstructor/tytacademy.png" alt="TYT Academy Logo">
        </div>
    </div>
    <div class="container_menu">
        <div class="menu">
            <nav>
                <ul>
                    <li><a href="../vista/inicioinstructor.php" id="selected"></a></li>
                    <br>
                    <li><a href="../vista/pruebasINSTRUCTOR.php">Pruebas</a></li>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#verPerfilModal">Mi perfil</a>
                        <ul>
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#verPerfilModal">Ver perfil</a></li>
                            <li><a href="#" onclick="confirmLogout()">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

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
                    <img src="../publico/imagenperfil/fotopredeterminada.jpg" class="rounded-circle" alt="Foto de perfil" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p><strong>Documento:</strong> <span id="perfilDocumento" class="dato-perfil"></span></p>
                        <p><strong>Nombre:</strong> <span id="perfilNombre" class="dato-perfil"></span></p>
                        <p><strong>Apellido:</strong> <span id="perfilApellido" class="dato-perfil"></span></p>
                        <p><strong>Email:</strong> <span id="perfilEmail" class="dato-perfil"></span></p>
                        <p><strong>Celular:</strong> <span id="perfilCelular" class="dato-perfil"></span></p>
                        <p><strong>Módulo:</strong> <span id="perfilModulo" class="dato-perfil" style="pointer-events: none; color: gray;"></span></p>
                        <small class="text-muted">El módulo no puede ser editado.</small>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../publico/js/perfilInstructor.js"></script>
<script>
    function confirmLogout() {
        const confirmLogout = confirm('¿Está seguro que quiere cerrar sesión?');
        if (confirmLogout) {
            window.location.href = '../../APRENDIZ/vista/index.html'; // Cambia la ruta si es necesario
        }
    }
</script>

</body>
</html>