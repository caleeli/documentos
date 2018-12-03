<template>
    <hoja-ruta-reporte-form :type="$route.params.id"></hoja-ruta-reporte-form>
</template>

<script>
    export default {
        path: "/HojaRutaReporte/:id",
    };
</script>
