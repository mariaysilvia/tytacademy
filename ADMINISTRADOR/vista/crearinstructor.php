
<?php include '../vista/navbarADMIN.php'; ?> <!-- Incluye el navbar aquí -->
        <div class="form-container">
            <section class="form-registerINS">
            <img src="../publico/imagenesadmin/tytacademy.png" alt="TYTAcademy">
        </a>
        <h2>¿Desea registrar a un instructor?</h2>
        <h4>¡Ingrese los pasos para continuar!</h4>

        <form id="registerINS-form">
            <label for="documento">Documento:</label>
            <input class="controls" type="text" name="documento" id="documento" 
                placeholder="Ingrese el documento del instructor." 
                pattern="[0-9]*" 
                title="Solo se permiten números"
                required>
            <label for="nombres">Nombre:</label>
            <input class="controls" type="text" name="nombres" id="nombres" 
                placeholder="Ingrese su nombre." required>
    
            <label for="apellidos">Apellido:</label>
            <input class="controls" type="text" name="apellidos" id="apellidos" 
                placeholder="Ingrese su apellido." required>
    
            <label for="correo">Correo Electrónico:</label>
            <input class="controls" type="email" name="correo" id="correo" 
                placeholder="Ingrese su correo electrónico." required>
    
            <label for="clave">Clave:</label>
            <input class="controls" type="password" name="clave" id="clave" 
                placeholder="Ingrese su contraseña." required>
    
            <label for="celular">Celular:</label>
            <input class="controls" type="text" name="celular" id="celular" 
                placeholder="Ingrese su celular.">
            
            <label for="modulo">Modulo:</label>
            <select class="controls" name="modulo" id="modulo" required>
                <option value="">Cargando módulos...</option>
            </select>
            
            <button class="botons" type="button" id="btnGuardarInstructor" onclick="guardarInstructor()">Guardar Instructor</button>
    </section>
</div>

<!-- Enlace al archivo JavaScript -->
<script src="../publico/js/instructor.js"></script>
</body>
</html>