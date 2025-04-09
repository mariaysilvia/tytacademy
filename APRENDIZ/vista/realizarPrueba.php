<?php include 'navbar.php'; ?>

<?php
// Obtener el tipo de prueba de la URL
$tipoPrueba = $_GET['tipo'] ?? '';

// Determinar qué formulario mostrar según el tipo de prueba
switch ($tipoPrueba) {
    case 'comunicacion':
        include '../formulariosiniciomodulos/formularioscomunicacion.php';
        break;
    case 'critica':
        include '../formulariosiniciomodulos/formulariolecturacritica.php';
        break;
    case 'razonamiento':
        include '../formulariosiniciomodulos/formulariorazonamiento.php';
        break;
    case 'ciudadana':
        include '../formulariosiniciomodulos/formulariosciudadana.php';
        break;
    case 'ingles':
        include '../formulariosiniciomodulos/formularioingles.php';
        break;
    default:
        echo "Tipo de prueba no válido";
        break;
}
?>

<div id="contenedorPreguntas" style="display: none;">
    <form id="formPreguntas">
        <div id="preguntas"></div>
        <button type="submit" class="btn-enviar">Enviar Respuestas</button>
    </form>
</div>

<style>
.contenedorPreguntas {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.pregunta {
    margin-bottom: 2rem;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.pregunta img {
    max-width: 100%;
    height: auto;
    margin-bottom: 1rem;
}

.respuestas {
    display: grid;
    gap: 0.5rem;
}

.respuesta {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
}

.respuesta:hover {
    background-color: #f5f5f5;
}

.respuesta input[type="radio"] {
    margin-right: 0.5rem;
}

.btn-enviar {
    background-color: #4CAF50;
    color: white;
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    width: 100%;
    margin-top: 1rem;
}

.btn-enviar:hover {
    background-color: #45a049;
}
</style>

<script>
// Modificar el formulario existente para que use AJAX
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.form-register form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const areas = document.getElementById('areas').value;
            const preguntas = document.getElementById('preguntas').value;
            const tipoPrueba = '<?php echo $tipoPrueba; ?>';

            // Mostrar mensaje de carga
            const contenedorPreguntas = document.getElementById('preguntas');
            contenedorPreguntas.innerHTML = '<div class="cargando">Cargando preguntas...</div>';
            document.getElementById('contenedorPreguntas').style.display = 'block';

            fetch('../controlador/seleccionarPreguntas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tipoPrueba: tipoPrueba,
                    areas: areas,
                    preguntas: preguntas
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarPreguntas(data.data);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar las preguntas');
            });
        });
    }
});

function mostrarPreguntas(preguntas) {
    const contenedor = document.getElementById('preguntas');
    contenedor.innerHTML = '';
    
    preguntas.forEach((pregunta, index) => {
        const divPregunta = document.createElement('div');
        divPregunta.className = 'pregunta';
        divPregunta.innerHTML = `
            <h3>Pregunta ${index + 1}</h3>
            ${pregunta.imagen ? `<img src="../publico/imagenesPREGUNTAS/${pregunta.imagen}" alt="Imagen pregunta">` : ''}
            <p>${pregunta.pregunta}</p>
            <div class="respuestas">
                ${pregunta.respuestas.map(respuesta => `
                    <label class="respuesta">
                        <input type="radio" name="pregunta_${pregunta.id}" value="${respuesta.id}" required>
                        ${respuesta.texto}
                    </label>
                `).join('')}
            </div>
        `;
        contenedor.appendChild(divPregunta);
    });
}

document.getElementById('formPreguntas').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const respuestas = {};
    const inputs = document.querySelectorAll('input[type="radio"]:checked');
    
    inputs.forEach(input => {
        const idPregunta = input.name.split('_')[1];
        respuestas[idPregunta] = input.value;
    });

    // Aquí puedes enviar las respuestas al servidor
    console.log('Respuestas:', respuestas);
    // TODO: Implementar el envío de respuestas
});
</script>

<?php include 'footer.php'; ?> 