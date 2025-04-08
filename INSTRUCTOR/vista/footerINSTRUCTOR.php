<!--footer-->

<footer class="footer-distributed">
    <div class="footer-left">
        <div class="logo">
            <img src="../publico/imagenesinstructor/tytacademy.png" alt="TYTAcademy">
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
<script src="../publico/js/botonarriba.js"></script>
<script src="../publico/js/logininstructor.js"></script>
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