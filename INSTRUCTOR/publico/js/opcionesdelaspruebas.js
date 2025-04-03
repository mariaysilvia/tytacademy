function toggleImageOptions() {
    const select = document.getElementById('documento');
    const opcionesContainer = document.getElementById('opciones-container');
    const opcionesImagenContainer = document.getElementById('opcionesimagen-container');

    if (select.value === 'si') {
        opcionesImagenContainer.style.display = 'block';
        opcionesContainer.style.display = 'none';
    } else if (select.value === 'no') {
        opcionesContainer.style.display = 'block';
        opcionesImagenContainer.style.display = 'none';
    } else { // Reinicio
        opcionesContainer.style.display = 'none';
        opcionesImagenContainer.style.display = 'none';

        // Reiniciar opciones de texto
        while (opcionesContainer.firstChild) {
            opcionesContainer.removeChild(opcionesContainer.firstChild);
        }
        const nuevaOpcion = document.createElement('div');
        nuevaOpcion.classList.add('opcion-container');
        nuevaOpcion.innerHTML = `
            <input type="radio" id="opcionA" name="opciones" value="Opción A">
            <label for="opcionA">Opción A</label>
            <textarea id="opcionA-text" rows="2" cols="50" placeholder="Ingrese su opción."></textarea>
        `;
        opcionesContainer.appendChild(nuevaOpcion);
        const linea = document.createElement('div');
        linea.classList.add('linea');
        opcionesContainer.appendChild(linea);
        const masOpciones = document.createElement('div');
        masOpciones.classList.add('opcion-container');
        masOpciones.innerHTML = `
            <label for="más">¿Desea agregar más opciones?</label>
            <a href="#" class="opcion-enlace" onclick="agregarOpcion(); return false;">Más opciones</a>
        `;
        opcionesContainer.appendChild(masOpciones);

        // Reiniciar opciones de imagen
        while (opcionesImagenContainer.firstChild) {
            opcionesImagenContainer.removeChild(opcionesImagenContainer.firstChild);
        }
        const nuevaImagenOpcion = document.createElement('div');
        nuevaImagenOpcion.classList.add('opcionimagen-container');
        nuevaImagenOpcion.innerHTML = `
            <input type="radio" id="imagenA" name="opcionesimagen" value="imagenA">
            <label for="imagenA">Imagen A</label>
            <input type="file" id="imagenA-file" accept="image/*" onchange="previewImage(this)">
            <img id="imagenA-preview" src="#" alt="Vista previa" style="max-width: 100px; max-height: 100px; display: none;">
        `;
        opcionesImagenContainer.appendChild(nuevaImagenOpcion);
        const lineaImagen = document.createElement('div');
        lineaImagen.classList.add('linea');
        opcionesImagenContainer.appendChild(lineaImagen);
        const masOpcionesImagen = document.createElement('div');
        masOpcionesImagen.classList.add('opcionimagen-container');
        masOpcionesImagen.innerHTML = `
            <label for="más">¿Desea agregar más opciones?</label>
            <a href="#" class="opcionimagen-enlace" onclick="agregarImagen(); return false;">Más opciones</a>
        `;
        opcionesImagenContainer.appendChild(masOpcionesImagen);
    }
}

function agregarOpcion() {
    const container = document.getElementById('opciones-container');
    const numOpciones = container.querySelectorAll('.opcion-container').length;
    const nuevaOpcion = document.createElement('div');
    nuevaOpcion.classList.add('opcion-container');

    const letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    const letra = letras[numOpciones - 1];

    nuevaOpcion.innerHTML = `
        <input type="radio" id="opcion${letra}" name="opciones" value="Opción ${letra}">
        <label for="opcion${letra}">Opción ${letra}</label>
        <textarea id="opcion${letra}-text" rows="2" cols="50" placeholder="Ingrese su opción."></textarea>
    `;

    // Corrección: Busca la linea dentro del contenedor actual
    const linea = container.querySelector('.linea');
    container.insertBefore(nuevaOpcion, linea); 
}

function agregarImagen() {
    const container = document.getElementById('opcionesimagen-container');
    const numOpciones = container.querySelectorAll('.opcionimagen-container').length;
    const nuevaOpcion = document.createElement('div');
    nuevaOpcion.classList.add('opcionimagen-container');

    const letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    const letra = letras[numOpciones -1];

    nuevaOpcion.innerHTML = `
        <input type="radio" id="imagen${letra}" name="opcionesimagen" value="imagen${letra}">
        <label for="imagen${letra}">Imagen ${letra}</label>
        <input type="file" id="imagen${letra}-file" accept="image/*" onchange="previewImage(this)">
        <img id="imagen${letra}-preview" src="#" alt="Vista previa" style="max-width: 100px; max-height: 100px; display: none;">
    `;

    // Corrección: Busca la linea dentro del contenedor actual
    const linea = container.querySelector('.linea');
    container.insertBefore(nuevaOpcion, linea); 
}
