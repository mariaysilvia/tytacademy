// Función para cargar los módulos dinámicamente desde la base de datos
function cargarModulos() {
    const moduloSelect = document.getElementById('modulo');
    if (!moduloSelect) {
        console.warn('El elemento con ID "modulo" no existe en esta página. Se omite cargarModulos.');
        return;
    }

    fetch('../../ADMINISTRADOR/controlador/instructor.php', {
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
        
        moduloSelect.innerHTML = '<option value="">Seleccione el módulo al que pertenece:</option>';
        data.data.forEach(modulo => {
            const option = document.createElement('option');
            option.value = modulo.idModulo;
            option.textContent = modulo.modulo;
            moduloSelect.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Error al cargar los módulos:', error);
        alert('Error al cargar los módulos: ' + error.message);
    });
}

// Llamar a cargarModulos solo si es necesario
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('modulo')) {
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
        clave: clave, // Incluye la clave en los datos enviados
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
    .then(response => {
        console.log('Estado de la respuesta:', response.status); // Agregado para depuración
        return response.text(); // Cambiado a text() para capturar cualquier salida inesperada
    })
    .then(text => {
        console.log('Texto de la respuesta:', text); // Agregado para depuración
        try {
            const data = JSON.parse(text); // Intenta convertir el texto a JSON
            console.log('Respuesta del servidor (JSON):', data); // Agregado para depuración
            alert(data.message); // Mostrar el mensaje generado desde PHP
            if (data.success) {
                document.getElementById('registerINS-form').reset(); // Limpiar el formulario
            }
        } catch (error) {
            console.error('Error al analizar la respuesta JSON:', error);
            alert('Error inesperado: ' + text); // Mostrar el texto de la respuesta para depuración
        }
    })
    .catch(error => {
        console.error('Error al guardar el instructor:', error); // Agregado para depuración
        alert('Error al guardar el instructor: ' + error.message);
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

            // Iterar sobre cada aprendiz y crear una tarjeta para cada uno
            data.data.forEach(aprendiz => {
                const card = document.createElement('div');
                card.className = 'card-aprendiz';
                card.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">${aprendiz.nombres} ${aprendiz.apellidos}</h5>
                            <p class="card-text">Documento: ${aprendiz.documento}</p>
                            <p class="card-text">Correo: ${aprendiz.correo}</p>
                            <p class="card-text">Celular: ${aprendiz.celular}</p>
                            <button class="btn btn-primary btn-sm" onclick="abrirModalEditar(${aprendiz.idAprendiz}, '${aprendiz.nombres}', '${aprendiz.apellidos}', '${aprendiz.documento}', '${aprendiz.correo}', '${aprendiz.clave}', '${aprendiz.celular}')">Editar</button>
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
            console.log('Estado HTTP:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Respuesta del servidor:', data);
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

            // Iterar sobre cada instructor y crear una tarjeta para cada uno
            data.data.forEach(instructor => {
                const card = document.createElement('div');
                card.className = 'card-instructor';
                card.innerHTML = `
                    <div class="card-body">
                        <h5 class="card-title">${instructor.nombre} ${instructor.apellido}</h5>
                        <p class="card-text">Documento: ${instructor.documento}</p>
                        <p class="card-text">Correo: ${instructor.email}</p>
                        <p class="card-text">Celular: ${instructor.celular}</p>
                        <p class="card-text">Módulo: ${instructor.idModulo}</p>
                        <button class="btn btn-primary btn-sm" onclick="abrirModalEditarInstructor(${instructor.idInstructor}, '${instructor.nombre}', '${instructor.apellido}', '${instructor.documento}', '${instructor.email}', '${instructor.celular}', '${instructor.idModulo}')">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarInstructor(${instructor.idInstructor})">Eliminar</button>
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

