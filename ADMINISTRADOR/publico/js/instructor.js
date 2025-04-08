// Función para cargar los módulos dinámicamente desde la base de datos
function cargarModulos() {
    const moduloSelect = document.getElementById('modulo');
    const editModuloSelect = document.getElementById('edit_modulo');
    
    // Si no hay ningún select de módulos en la página, salir silenciosamente
    if (!moduloSelect && !editModuloSelect) {
        return;
    }

    fetch('../controlador/instructor.php', {
        method: 'POST',
        body: JSON.stringify({ action: 'getModulos' }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error('La respuesta no es un JSON válido: ' + text);
            }
        });
    })
    .then(data => {
        if (!data.success) {
            throw new Error(data.message || 'Error al cargar los módulos');
        }
        
        // Llenar el select de módulos si existe
        if (moduloSelect) {
            moduloSelect.innerHTML = '<option value="">Seleccione el módulo al que pertenece:</option>';
            data.data.forEach(modulo => {
                const option = document.createElement('option');
                option.value = modulo.idModulo;
                option.textContent = modulo.modulo;
                moduloSelect.appendChild(option);
            });
        }
        
        // Llenar el select de módulos del modal de edición si existe
        if (editModuloSelect) {
            editModuloSelect.innerHTML = '<option value="">Seleccione el módulo al que pertenece:</option>';
            data.data.forEach(modulo => {
                const option = document.createElement('option');
                option.value = modulo.idModulo;
                option.textContent = modulo.modulo;
                editModuloSelect.appendChild(option);
            });
        }
    })
    .catch(error => {
        console.error('Error al cargar los módulos:', error);
        alert('Error al cargar los módulos: ' + error.message);
    });
}

// Llamar a cargarModulos solo si es necesario
document.addEventListener('DOMContentLoaded', () => {
    // Solo cargar módulos si estamos en la página de crear instructor o en el modal de edición
    if (document.getElementById('modulo') || document.getElementById('edit_modulo')) {
        cargarModulos();
    }
    if (document.getElementById('listaraprendices')) {
        cargarAprendices();
    }
    if (document.getElementById('listarinstructores')) {
        cargarInstructores();
    }
});

// Función para guardar el instructor
function guardarInstructor() {
    const documento = document.getElementById('documento').value;
    const nombre = document.getElementById('nombres').value;
    const apellido = document.getElementById('apellidos').value;
    const email = document.getElementById('correo').value;
    const clave = document.getElementById('clave').value;
    const celular = document.getElementById('celular').value;
    const modulo = document.getElementById('modulo').value;

    // Validar que los campos obligatorios no estén vacíos
    if (!documento || !nombre || !apellido || !email || !clave || !modulo) {
        alert('Todos los campos obligatorios deben ser completados.');
        return;
    }

    const requestData = {
        action: 'guardarInstructor',
        documento: documento,
        nombre: nombre,
        apellido: apellido,
        email: email,
        clave: clave,
        celular: celular || '', // Asegurarse de que celular no sea null
        modulo: modulo
    };

    fetch('../controlador/instructor.php', {
        method: 'POST',
        body: JSON.stringify(requestData),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.text())
    .then(text => {
        try {
            const data = JSON.parse(text);
            alert(data.message);
            if (data.success) {
                document.getElementById('registerINS-form').reset();
            }
        } catch (error) {
            console.error('Error al analizar la respuesta JSON:', error);
            alert('Error inesperado: ' + text);
        }
    })
    .catch(error => {
        console.error('Error al guardar el instructor:', error);
        alert('Error al guardar el instructor: ' + error.message);
    });
}

// Función para editar instructor
function editarInstructor(id) {
    // Obtener los datos del instructor
    fetch('../controlador/instructor.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'obtenerInstructor',
            id: id
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const instructor = data.data;
                // Llenar el modal con los datos del instructor
                document.getElementById('edit_documento').value = instructor.documento;
                document.getElementById('edit_nombres').value = instructor.nombre;
                document.getElementById('edit_apellidos').value = instructor.apellido;
                document.getElementById('edit_correo').value = instructor.email;
                document.getElementById('edit_celular').value = instructor.celular || '';
                document.getElementById('edit_modulo').value = instructor.idModulo;
                document.getElementById('edit_id').value = instructor.idInstructor;
                
                // Abrir el modal usando la API de Bootstrap 5
                const modalElement = document.getElementById('editarInstructorModal');
                if (modalElement) {
                    // Verificar si ya existe una instancia del modal
                    let modal = bootstrap.Modal.getInstance(modalElement);
                    if (!modal) {
                        // Si no existe, crear una nueva instancia
                        modal = new bootstrap.Modal(modalElement);
                    }
                    modal.show();
                } else {
                    console.error('El elemento modal no existe en la página');
                }
            } else {
                alert('Error al obtener los datos del instructor');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al obtener los datos del instructor');
        });
}

// Función para guardar los cambios del instructor editado
function guardarCambiosInstructor() {
    const id = document.getElementById('edit_id').value;
    const documento = document.getElementById('edit_documento').value;
    const nombre = document.getElementById('edit_nombres').value;
    const apellido = document.getElementById('edit_apellidos').value;
    const email = document.getElementById('edit_correo').value;
    const celular = document.getElementById('edit_celular').value;
    const modulo = document.getElementById('edit_modulo').value;

    const requestData = {
        action: 'editarInstructor',
        id: id,
        documento: documento,
        nombre: nombre,
        apellido: apellido,
        email: email,
        celular: celular,
        modulo: modulo
    };

    fetch('../controlador/instructor.php', {
        method: 'POST',
        body: JSON.stringify(requestData),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            // Cerrar el modal
            const modalElement = document.getElementById('editarInstructorModal');
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            }
            // Recargar la lista de instructores
            cargarInstructores();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar los cambios');
    });
}

// Función para cargar los aprendices
function cargarAprendices() {
    fetch('../controlador/listaraprendices.php')
        .then(response => {
            console.log('Estado HTTP:', response.status); // Agregado para depuración
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Respuesta del servidor:', data); // Agregado para depuración
            const listaraprendices = document.getElementById('listaraprendices');
            if (!listaraprendices) {
                console.error('El elemento con ID "listaraprendices" no existe en esta página.');
                return;
            }

            listaraprendices.innerHTML = ''; // Limpiar el contenedor

            if (!data.success) {
                listaraprendices.innerHTML = `<p>${data.message}</p>`;
                return;
            }

            // Crear el contenedor para las tarjetas
            const cardContainer = document.createElement('div');
            cardContainer.classList.add('card-container');

                        // Calcular columnas necesarias (mínimo 3)
                        const columnCount = Math.max(3, Math.ceil(data.data.length / 2));
                        cardContainer.style.gridTemplateColumns = `repeat(${columnCount}, 1fr)`;
                        cardContainer.style.width = `calc(300px * ${columnCount} + 20px * ${columnCount - 1})`;

            // Iterar sobre cada aprendiz y crear una tarjeta para cada uno
            data.data.forEach(aprendiz => {
                const card = document.createElement('div');
                card.className = 'card-aprendiz';
                card.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">${aprendiz.nombres} ${aprendiz.apellidos}</h5>
                            <p class="card-text"><strong>Documento: </strong>${aprendiz.documento}</p>
                            <p class="card-text"><Strong>Correo: </Strong>${aprendiz.correo}</p>
                            <p class="card-text"><Strong>Celular: </Strong>${aprendiz.celular}</p>
                            <button class="btn btn-danger btn-sm" onclick="eliminarAprendiz(${aprendiz.idAprendiz})">Eliminar</button>
                        </div>
                `;
                cardContainer.appendChild(card);
            });
                listaraprendices.appendChild(cardContainer);
            })
        .catch(error => {
            console.error('Error al cargar aprendices:', error); // Agregado para depuración
            alert('Error al cargar los aprendices: ' + error.message);
        });
}

// Función para eliminar un aprendiz
function eliminarAprendiz(id) {
    console.log('ID del aprendiz a eliminar:', id); // Depuración
    if (confirm('¿Estás seguro que deseas eliminar este aprendiz?')) {
        const requestData = {
            action: 'eliminarAprendiz',
            id: id
        };

        fetch('../controlador/listaraprendices.php', {
            method: 'POST',
            body: JSON.stringify(requestData),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data); // Depuración
            alert(data.message); // Mostrar el mensaje generado desde PHP
            if (data.success) {
                cargarAprendices(); // Recargar la lista de aprendices después de eliminar
            }
        })
        .catch(error => {
            console.error('Error al eliminar el aprendiz:', error);
            alert('Error al eliminar el aprendiz: ' + error.message);
        });
    }
}

// Función para cargar los instructores
function cargarInstructores() {
    fetch('../controlador/listarinstructores.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const listarinstructores = document.getElementById('listarinstructores');
            if (!listarinstructores) {
                console.error('El elemento con ID "listarinstructores" no existe en esta página.');
                return;
            }

            listarinstructores.innerHTML = ''; // Limpiar el contenedor

            if (!data.success) {
                listarinstructores.innerHTML = `<p>${data.message}</p>`;
                return;
            }

            // Crear el contenedor para las tarjetas
            const cardContainer = document.createElement('div');
            cardContainer.classList.add('card-container');

            // Calcular columnas necesarias (mínimo 3)
            const columnCount = Math.max(3, Math.ceil(data.data.length / 2));
            cardContainer.style.gridTemplateColumns = `repeat(${columnCount}, 1fr)`;
            cardContainer.style.width = `calc(300px * ${columnCount} + 20px * ${columnCount - 1})`;

            // Iterar sobre cada instructor y crear una tarjeta para cada uno
            data.data.forEach(instructor => {
                const card = document.createElement('div');
                card.className = 'card-instructor';
                card.innerHTML = `
                    <div class="card-body">
                        <h5 class="card-title">${instructor.nombre} ${instructor.apellido}</h5>
                        <p class="card-text"><strong>Documento: </strong>${instructor.documento}</p>
                        <p class="card-text"><strong>Correo: </strong>${instructor.email}</p>
                        <p class="card-text"><strong>Celular: </strong>${instructor.celular ? instructor.celular : 'No registrado'}</p>
                        <p class="card-text"><strong>Módulo: </strong>${instructor.nombreModulo || instructor.idModulo}</p>
                        <div class="button-group">
                            <button class="btn btn-primary btn-sm" onclick="editarInstructor(${instructor.idInstructor})">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarInstructor(${instructor.idInstructor})">Eliminar</button>
                        </div>
                    </div>
                `;
                cardContainer.appendChild(card);
            });

            listarinstructores.appendChild(cardContainer);
        })
        .catch(error => {
            console.error('Error al cargar instructores:', error);
            alert('Error al cargar los instructores: ' + error.message);
        });
}

// Función para eliminar un instructor
function eliminarInstructor(id) {
    if (confirm('¿Estás seguro que deseas eliminar este instructor?')) {
        const requestData = {
            action: 'eliminarInstructor',
            id: id
        };

        fetch('../controlador/listarinstructores.php', {
            method: 'POST',
            body: JSON.stringify(requestData),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                cargarInstructores(); // Recargar la lista de instructores después de eliminar
            }
        })
        .catch(error => {
            console.error('Error al eliminar el instructor:', error);
            alert('Error al eliminar el instructor: ' + error.message);
        });
    }
}
