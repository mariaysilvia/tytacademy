function iniciarLogin() {
    const form = document.getElementById('login-form');
    form.onsubmit = function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('documento', document.getElementById('documento').value);
        formData.append('correo', document.getElementById('correo').value);
        formData.append('clave', document.getElementById('clave').value);

        if (!formData.get('documento') || !formData.get('correo') || !formData.get('clave')) {
            mostrarMensaje('Por favor complete todos los campos', 'error');
            return false;
        }

        fetch('../../INSTRUCTOR/controlador/logininstructor.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                mostrarMensaje('¡Inicio de sesión exitoso!', 'exito');
                setTimeout(function() {
                    window.location.href = '../../INSTRUCTOR/vista/inicioinstructor.php';
                }, 1000);
            } else {
                mostrarMensaje(data.message || 'Error en el inicio de sesión', 'error');
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            mostrarMensaje('Error en el servidor', 'error');
        });

        return false;
    };
}

function mostrarMensaje(mensaje, tipo) {
    const mensajeElement = document.getElementById('loginMessage');
    mensajeElement.textContent = mensaje;
    mensajeElement.className = tipo === 'error' ? 'mensaje error' : 'mensaje exito';
    mensajeElement.style.display = 'block';

    setTimeout(function() {
        mensajeElement.style.display = 'none';
    }, 3000);
}

// Iniciar cuando el documento esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', iniciarLogin);
} else {
    iniciarLogin();
} 