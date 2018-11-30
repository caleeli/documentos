<template>
    <hoja-ruta-reporte-form :type="$route.params.type"></hoja-ruta-reporte-form>
</template>

<script>
    export default {
        path: "/HojaRutaReporte/:type",
    };
</script>
