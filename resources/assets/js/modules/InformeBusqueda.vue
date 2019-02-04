<template>
    <informe-busqueda-lista :type="$route.params.type"></informe-busqueda-lista>
</template>

<script>
    export default {
        path: "/InformeBusqueda/:type",
        data() {
            return {
            };
        },
    };
</script>
