<template>
    <nota-oficio-busqueda-lista :type="$route.params.type"></nota-oficio-busqueda-lista>
</template>

<script>
    export default {
        path: "/NotaOficioBusqueda/:type",
        data() {
            return {
            };
        },
        mounted() {
            console.log('entroo');
        }
    };
</script>
