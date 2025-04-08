<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYT ACADEMY</title>
    <link rel="stylesheet" href="">
    <link rel="icon" href="../publico/imagenesinstructor/computador.png" type="image/x-icon">
    <link rel="stylesheet" href="../publico/css/iniciarsesioninstructor.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div id="video-background">
        <video autoplay muted loop>
            <source src="../publico/imagenesinstructor/fonditilloAZUL.mp4" type="video/mp4">
        </video>
    </div>
    <section class="form-register">
        <a href="../vista/principal.html">
            <img src="../publico/imagenesinstructor/tytacademy.png" alt="TYTAcademy">
        </a>
        <h2>Inicio de sesión del instructor</h2>
        <div class="form-container">
            <h4>¡Conoce más de TYTACADEMY!</h4>
            <form id="login-form">
                <label for="documento">Documento:</label>
                <input class="controls" type="text" name="documento" id="documento" placeholder="Ingrese su documento." required>
                
                <label for="correo">Correo Electrónico:</label>
                <input class="controls" type="email" name="correo" id="correo" placeholder="Ingrese su correo electrónico." required>
                
                <label for="clave">Clave:</label>
                <input class="controls" type="password" name="clave" id="clave" placeholder="Ingrese su clave." required>
                
                <input class="botons" type="submit" value="Iniciar sesión">
                <p><a href="../vista/index.html">¿Desea volver al inicio?</a></p>
            </form>
            <!-- Elemento para mostrar mensajes del sistema -->
            <div id="loginMessage" class="mensaje" style="display: none;"></div>
        </div>
    </section> 

    <!--boton de ir hacia arriba-->

<div id="button-up">
    <i class="fa-solid fa-chevron-up"></i>
</div>
    <?php include '../vista/footerINSTRUCTOR.php'; ?> <!-- Incluye el footer aquí -->