/* Seleziona il filtro e il table-container
var filtro = document.querySelector('.filtro');
var tableContainer = document.querySelector('.table-container');

// Funzione per impostare l'altezza del table-container uguale all'altezza del filtro
function setTableContainerHeight() {
  // Calcola l'altezza del filtro
  var filtroHeight = filtro.offsetHeight;
  
  // Imposta l'altezza del table-container come altezza del filtro
  tableContainer.style.height = filtroHeight + 'px';
}

// Chiama la funzione per impostare l'altezza all'avvio e ogni volta che la pagina viene ridimensionata
setTableContainerHeight();
window.addEventListener('resize', setTableContainerHeight);*/
