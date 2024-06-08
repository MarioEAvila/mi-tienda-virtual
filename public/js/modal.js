document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-agregar-lista').forEach(button => {
        button.addEventListener('click', function() {
            const productoId = this.getAttribute('data-producto-id');

            fetch('/mi_tienda_virtual/public/index.php?page=lista&action=obtenerListas')
                .then(response => response.text())
                .then(text => {
                    alert('Raw response: ' + text); // Mostrar la respuesta cruda
                    if (!text) throw new Error('Empty response');
                    const listas = JSON.parse(text);
                    if (listas.error) {
                        alert('Error al obtener listas: ' + listas.error);
                        return;
                    }

                    const modalContent = document.querySelector('.modal-content');
                    modalContent.innerHTML = ''; // Limpiar contenido previo

                    if (listas.length === 0) {
                        modalContent.innerHTML = '<p>No tienes listas creadas.</p>';
                    } else {
                        listas.forEach(lista => {
                            const listItem = document.createElement('div');
                            listItem.innerHTML = `
                                <div>
                                    <input type="checkbox" id="lista_${lista.id}" data-lista-id="${lista.id}" data-producto-id="${productoId}">
                                    <label for="lista_${lista.id}">${lista.nombre}</label>
                                </div>
                            `;
                            modalContent.appendChild(listItem);
                        });
                    }

                    document.querySelector('.modal').style.display = 'block';
                    alert('Modal should be visible now');
                })
                .catch(error => {
                    alert('Error parsing JSON: ' + error);
                    console.error('Error parsing JSON:', error);
                });
        });
    });
});
