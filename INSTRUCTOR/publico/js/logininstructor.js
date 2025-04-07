document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const loginMessage = document.getElementById('loginMessage');

    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const documento = document.getElementById('documento').value;
        const correo = document.getElementById('correo').value;
        const clave = document.getElementById('clave').value;

        // Validación básica
        if (!documento || !correo || !clave) {
            mostrarMensaje('Por favor complete todos los campos', 'error');
            return;
        }

        // Crear objeto con los datos
        const datos = {
            documento: documento,
            email: correo,
            clave: clave
        };

        // Enviar solicitud al servidor
        fetch('../INSTRUCTOR/controlador/logininstructor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                mostrarMensaje('¡Inicio de sesión exitoso!', 'exito');
                // Redirigir al panel del instructor después de 1 segundo
                setTimeout(() => {
                    window.location.href = '../INSTRUCTOR/vista/panelinstructor.php';
                }, 1000);
            } else {
                mostrarMensaje(data.mensaje || 'Error en el inicio de sesión', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error en el servidor', 'error');
        });
    });

    function mostrarMensaje(mensaje, tipo) {
        loginMessage.textContent = mensaje;
        loginMessage.className = tipo === 'error' ? 'mensaje error' : 'mensaje exito';
        loginMessage.style.display = 'block';

        // Ocultar el mensaje después de 3 segundos
        setTimeout(() => {
            loginMessage.style.display = 'none';
        }, 3000);
    }
}); 