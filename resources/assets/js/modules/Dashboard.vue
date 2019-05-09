<template>
    <desktop :links="accessLinks">
    </desktop>
</template>

<script>
    require("../../images/hoja-de-ruta.svg");
    require("../../images/hoja-de-ruta.svg");
    require("../../images/busqueda.svg");
    require("../../images/hoja-de-ruta-interna.svg");
    require("../../images/hoja-de-ruta-interna.svg");
    require("../../images/busqueda-interna.svg");
    require("../../images/hoja-de-ruta-solicitud.svg");
    require("../../images/hoja-de-ruta-solicitud.svg");
    require("../../images/busqueda-solicitud.svg");
    require("../../images/nota-oficio.svg");
    require("../../images/nota-oficio.svg");
    require("../../images/busqueda-nota-oficio.svg");
    require("../../images/informes.svg");
    require("../../images/informes.svg");
    require("../../images/busqueda-informes.svg");
    require("../../images/comunicacion.svg");
    require("../../images/comunicacion.svg");
    require("../../images/busqueda-comunicacion.svg");
    require("../../images/reporte.svg");
    require("../../images/reporte-resumen.svg");

    const links = window.links;

    export default {
        path: "/",
        data() {
            return {
                accessLinks: this.currentItems(this.$route.query),
            };
        },
        methods: {
            runMacro(macro) {
                const params = Object.assign({}, macro);
                delete params.macro;
                this[macro.macro](params);
            },
            completeTask(params) {
                Process.completeTask(params);
            },
            currentItems(query) {
                if (query.item !== undefined && links[query.item].links instanceof Array) {
                    return links[query.item].links;
                }
                return links;
            },
        },
        watch: {
            '$route.query': {
                deep: true,
                handler(query) {
                    this.$set(this, 'accessLinks', this.currentItems(query));
                },
            }
        },
    };
</script>

<style lang="scss">
    .access-link {
        width: 1em;
    }
</style>
