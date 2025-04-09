document.addEventListener('DOMContentLoaded', function() {
    // Cargar perfil cuando se abre el modal
    document.getElementById('verPerfilModal').addEventListener('show.bs.modal', function () {
        cargarPerfil();
    });
});

function cargarPerfil() {
    fetch('../../INSTRUCTOR/controlador/InstructorController.php?action=obtenerPerfil')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('perfilDocumento').textContent = data.instructor.documento || '';
                document.getElementById('perfilNombre').textContent = data.instructor.nombre || '';
                document.getElementById('perfilApellido').textContent = data.instructor.apellido || '';
                document.getElementById('perfilEmail').textContent = data.instructor.email || '';
                document.getElementById('perfilCelular').textContent = data.instructor.celular || '';
                document.getElementById('perfilEstado').textContent = data.instructor.estado || '';
                document.getElementById('perfilModulo').textContent = data.instructor.nombreModulo || '';
            } else {
                throw new Error(data.message || 'Error al cargar el perfil');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar el perfil: ' + error.message);
        });
}
function habilitarEdicion() {
    const campos = document.querySelectorAll('.dato-perfil');
    campos.forEach(campo => {
        // Excluir el campo del módulo de la edición
        if (campo.id === 'perfilModulo') return;

        const valor = campo.textContent;
        campo.innerHTML = `<input type="text" class="form-control" value="${valor}">`;
    });
    document.getElementById('btnEditar').style.display = 'none';
    document.getElementById('btnGuardar').style.display = 'block';
}
function guardarCambios() {
    const formData = new FormData();
    formData.append('documento', document.querySelector('#perfilDocumento input').value);
    formData.append('nombre', document.querySelector('#perfilNombre input').value);
    formData.append('apellido', document.querySelector('#perfilApellido input').value);
    formData.append('email', document.querySelector('#perfilEmail input').value);
    formData.append('celular', document.querySelector('#perfilCelular input').value);

    fetch('../../INSTRUCTOR/controlador/InstructorController.php?action=actualizarPerfil', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Perfil actualizado correctamente');
            cargarPerfil();
            document.getElementById('btnEditar').style.display = 'block';
            document.getElementById('btnGuardar').style.display = 'none';
        } else {
            throw new Error(data.message || 'Error al actualizar el perfil');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el perfil: ' + error.message);
    });
} 