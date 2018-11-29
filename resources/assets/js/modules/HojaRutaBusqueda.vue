<template>
    <hoja-ruta-busqueda-lista :type="$route.params.type"></hoja-ruta-busqueda-lista>
</template>

<script>
    export default {
        path: "/HojaRutaBusqueda/:type",
        data() {
            return {
            };
        },
    };
</script>
