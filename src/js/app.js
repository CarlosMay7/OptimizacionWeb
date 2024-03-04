const actualizar = document.querySelector('.actualizar');
const formBusqueda = document.querySelector('.busqueda');
const formFiltros = document.querySelector('.filtros');

actualizar.addEventListener('click', () => {
    formBusqueda.submit();
    formFiltros.submit();
});
