// Función para recolectar respuestas del formulario
function recolectarRespuestas() {
    const respuestas = {};
    const inputs = document.getElementsByTagName('input');
    
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].type === 'radio' && inputs[i].checked) {
            respuestas[inputs[i].name] = inputs[i].value;
        }
    }
    
    return respuestas;
}

// Función para obtener el tipo de prueba de la URL
function obtenerTipoPrueba() {
    const url = window.location.href;
    const tipo = url.split('tipo=')[1];
    return tipo || 'critica';
}

// Función para mostrar resultados
function mostrarResultados(correctas, incorrectas) {
    document.getElementById('resultados').innerText = `Respuestas correctas: ${correctas}`;
    document.getElementById('incorrectas').innerText = `Respuestas incorrectas: ${incorrectas}`;
    
    const emoji = document.querySelector('.emoji');
    if (emoji) {
        emoji.style.display = 'block';
    }
}

// Función para mostrar error
function mostrarError(mensaje) {
    alert('Error al corregir la prueba: ' + mensaje);
}

// Función principal para corregir la prueba
function corregirPrueba() {
    const respuestas = recolectarRespuestas();
    const tipoPrueba = obtenerTipoPrueba();
    
    fetch('/trabajos/PruebasTYT/APRENDIZ/controlador/corregirPrueba.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            respuestas: respuestas,
            tipoPrueba: tipoPrueba
        })
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            mostrarResultados(data.correctas, data.incorrectas);
        } else {
            mostrarError(data.error);
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        mostrarError('Error al enviar las respuestas');
    });
}

// Asignar la función al botón de corregir
const btnCorregir = document.getElementById('btnCorregir');
if (btnCorregir) {
    btnCorregir.onclick = corregirPrueba;
}
