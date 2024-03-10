const actualizar = document.querySelector('.actualizar');
const formBusqueda = document.querySelector('.busqueda');
const formFiltros = document.querySelector('.filtros');
const articulos = document.querySelectorAll('.articulo');

actualizar.addEventListener('click', () => {
    formBusqueda.submit();
});

articulos.forEach(articulo => {
    const figureArticulo = articulo.querySelector('figure');
    let imagenArticulo = articulo.querySelector('figure img');
    let imagenActual = articulo.querySelector('#imagen-articulo');

    if(imagenArticulo) {
        imagenActual.src = imagenArticulo.src;
        figureArticulo.remove();
    } else {
        figureArticulo.remove();
        imagenActual.src = '/img/feedHub.png';
    }
});
