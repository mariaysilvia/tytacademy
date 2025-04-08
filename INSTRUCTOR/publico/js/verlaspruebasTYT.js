// Función para eliminar una pregunta
async function eliminarPregunta(idPregunta) {
    if (!confirm('¿Estás seguro de que deseas eliminar esta pregunta?')) {
        return;
    }
    
    try {
        const response = await fetch(`../controlador/pregunta.php?accion=eliminar&id=${idPregunta}`, {
            method: 'POST'
        });
        const data = await response.json();
        
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Error al eliminar la pregunta');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al eliminar la pregunta');
    }
}

// Función para mostrar mensajes
function mostrarMensaje(mensaje, tipo) {
    const mensajeDiv = document.getElementById('mensaje');
    if (!mensajeDiv) {
        const nuevoMensajeDiv = document.createElement('div');
        nuevoMensajeDiv.id = 'mensaje';
        nuevoMensajeDiv.className = `mensaje ${tipo}`;
        nuevoMensajeDiv.style.display = 'none';
        document.body.insertBefore(nuevoMensajeDiv, document.body.firstChild);
    }
    
    mensajeDiv.textContent = mensaje;
    mensajeDiv.className = `mensaje ${tipo}`;
    mensajeDiv.style.display = 'block';
    
    setTimeout(() => {
        mensajeDiv.style.display = 'none';
    }, 3000);
}

// Inicializar cuando el documento esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Agregar manejadores de eventos para los botones de eliminar
    document.querySelectorAll('[data-eliminar-pregunta]').forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const idPregunta = this.getAttribute('data-eliminar-pregunta');
            eliminarPregunta(idPregunta);
        });
    });
}); 