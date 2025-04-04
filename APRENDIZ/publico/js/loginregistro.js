console.log('loginregistro.js cargado correctamente');

// Función para mostrar mensajes
function mostrarMensaje(elementId, mensaje, color) {
    const elemento = document.getElementById(elementId);
    if (elemento) {
        elemento.textContent = mensaje;
        elemento.style.color = color;
        elemento.style.display = mensaje ? 'block' : 'none';
    }
}

// Función para validar documento
function validarDocumento(documento) {
    return /^\d+$/.test(documento);
}

// Función para validar la contraseña
function validarPassword(password) {
    if (password.length < 8) {
        return {
            valido: false,
            mensaje: "La contraseña debe tener al menos 8 caracteres"
        };
    }

    if (!/[0-9]/.test(password)) {
        return {
            valido: false,
            mensaje: "La contraseña debe contener al menos un número"
        };
    }

    if (!/[A-Z]/.test(password)) {
        return {
            valido: false,
            mensaje: "La contraseña debe contener al menos una letra mayúscula"
        };
    }

    if (!/[a-z]/.test(password)) {
        return {
            valido: false,
            mensaje: "La contraseña debe contener al menos una letra minúscula"
        };
    }
    
    return {
        valido: true,
        mensaje: "Contraseña válida"
    };
}

// Función para registrar usuario
async function registrarUsuario(formData) {
    try {
        mostrarMensaje("signupMessage", "Procesando registro...", "blue");
        
        const response = await fetch('../controlador/registro.php', {
            method: 'POST',
            body: formData
        });

        // Verificar si la respuesta es JSON válida
        let resultado;
        try {
            resultado = await response.json();
        } catch (error) {
            console.error("Error al parsear JSON:", error);
            mostrarMensaje("signupMessage", "Error en la respuesta del servidor", "red");
            return;
        }

        if (resultado.success) {
            mostrarMensaje("signupMessage", "¡Registro exitoso! Redirigiendo...", "green");
            setTimeout(() => {
                window.location.href = "../vista/iniciarsesion.html";
            }, 2000);
        } else {
            console.error("Error del servidor:", resultado.message);
            mostrarMensaje("signupMessage", resultado.message || "Error en el registro", "red");
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
        mostrarMensaje("signupMessage", error.message || "Error al procesar el registro", "red");
    }
}

// Función para iniciar sesión
async function iniciarSesion(formData) {
    try {
        mostrarMensaje("loginMessage", "Procesando inicio de sesión...", "blue");
        
        const response = await fetch('../controlador/login.php', {
            method: 'POST',
            body: formData
        });
        
        const resultado = await response.json();
        
        if (resultado.success) {
            mostrarMensaje("loginMessage", "¡Inicio de sesión exitoso! Redirigiendo...", "green");
            setTimeout(() => {
                window.location.href = "../vista/principalAprendiz.php";
            }, 2000);
        } else {
            mostrarMensaje("loginMessage", resultado.message || "Error en el inicio de sesión", "red");
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarMensaje("loginMessage", "Error al procesar el inicio de sesión", "red");
    }
}

// Función para cargar datos del perfil
async function cargarDatosPerfil() {
    try {
        const response = await fetch('../controlador/verperfil.php');
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error al cargar el perfil:', error);
        return { success: false, message: 'Error al cargar los datos del perfil' };
    }
}

// Función para actualizar perfil
async function actualizarPerfil(datos) {
    try {
        const response = await fetch('../controlador/actualizarperfil.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
        });
        
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Error al actualizar el perfil:', error);
        return { success: false, message: 'Error al actualizar el perfil' };
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Formulario de registro
    const registerForm = document.getElementById("register-form");
    if (registerForm) {
        registerForm.onsubmit = function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            const password = document.getElementById("contraseña").value;
            const confirmPassword = document.getElementById("confirmar-contraseña").value;
            const documento = document.getElementById("documento").value;

            // Validar documento
            if (!validarDocumento(documento)) {
                mostrarMensaje("signupMessage", "El documento solo debe contener números", "red");
                return;
            }

            // Validar contraseña
            const validacionPassword = validarPassword(password);
            if (!validacionPassword.valido) {
                mostrarMensaje("signupMessage", validacionPassword.mensaje, "red");
                return;
            }

            // Verificar que las contraseñas coincidan
            if (password !== confirmPassword) {
                mostrarMensaje("signupMessage", "Las contraseñas no coinciden", "red");
                return;
            }

            // Enviar datos al servidor
            registrarUsuario(formData);
        };

        // Validación en tiempo real del documento
        const documentoInput = document.getElementById("documento");
        if (documentoInput) {
            documentoInput.addEventListener('input', function() {
                if (!validarDocumento(this.value) && this.value !== '') {
                    mostrarMensaje("signupMessage", "El documento solo debe contener números", "red");
                } else {
                    mostrarMensaje("signupMessage", "", "black");
                }
            });
        }
    }

    // Formulario de inicio de sesión
    const loginForm = document.getElementById("login-form");
    if (loginForm) {
        loginForm.onsubmit = function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            iniciarSesion(formData);
        };
    }
});

// Exportar funciones necesarias para el perfil
window.cargarDatosPerfil = cargarDatosPerfil;
window.actualizarPerfil = actualizarPerfil;

async function guardarCambios() {
    try {
        const inputs = document.querySelectorAll('.modal-body input.form-control');
        const datos = {
            nombres: inputs[0].value,
            apellidos: inputs[1].value,
            correo: inputs[2].value,
            celular: inputs[3].value
        };

        const resultado = await actualizarPerfil(datos);
        
        if (resultado.success) {
            alert(resultado.message);
            const modalElement = document.getElementById('perfilModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
            window.location.reload();
        } else {
            alert(resultado.message || 'Error al actualizar el perfil');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar los cambios');
    }
}

// Agregar esta función para habilitar la edición
function habilitarEdicion() {
    const campos = ['perfilNombre', 'perfilApellido', 'perfilEmail', 'perfilCelular'];
    
    campos.forEach(campo => {
        const elemento = document.getElementById(campo);
        const valor = elemento.textContent;
        elemento.innerHTML = `<input type="text" class="form-control" value="${valor}">`;

    });

    document.getElementById('btnEditar').style.display = 'none';
    document.getElementById('btnGuardar').style.display = 'inline';
}