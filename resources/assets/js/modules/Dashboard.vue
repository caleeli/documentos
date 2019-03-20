<template>
    <desktop :links="accessLinks">
    </desktop>
</template>

<script>
    const links = Object.assign({
        0: {
            text: "Hoja de ruta externa",
            icon: require("../../images/hoja-de-ruta.svg"),
            description: "Registro busqueda y reporte",
            href: "/?item=0",
            links: [
                {
                    text: "Registrar",
                    icon: require("../../images/hoja-de-ruta.svg"),
                    description: "Hoja de ruta externa",
                    href: "/HojaRuta/externa/create",
                },
                {
                    icon: require("../../images/busqueda.svg"),
                    text: "Busqueda",
                    description: "Hoja de ruta externa",
                    href: "/HojaRutaBusqueda/externa",
                },
            ],
        },
        1: {
            text: "Hoja de ruta interna",
            icon: require("../../images/hoja-de-ruta-interna.svg"),
            description: "Registro busqueda y reporte",
            href: "/?item=1",
            links: [
                {
                    text: "Registrar",
                    icon: require("../../images/hoja-de-ruta-interna.svg"),
                    description: "Hoja de ruta interna",
                    href: "/HojaRuta/interna/create",
                },
                {
                    icon: require("../../images/busqueda-interna.svg"),
                    text: "Busqueda",
                    description: "Hoja de ruta interna",
                    href: "/HojaRutaBusqueda/interna",
                },
            ],
        },
        2: {
            text: "Solicitudes y denuncia",
            icon: require("../../images/hoja-de-ruta-solicitud.svg"),
            description: "Registro busqueda y reporte",
            href: "/?item=2",
            links: [
                {
                    text: "Registrar",
                    icon: require("../../images/hoja-de-ruta-solicitud.svg"),
                    description: "Solicitudes y denuncia",
                    href: "/HojaRuta/solicitud/create",
                },
                {
                    icon: require("../../images/busqueda-solicitud.svg"),
                    text: "Busqueda",
                    description: "Solicitudes y denuncia",
                    href: "/HojaRutaBusqueda/solicitud",
                },
            ],
        },
        3: {
            text: "Notas oficio",
            icon: require("../../images/nota-oficio.svg"),
            description: "Registro busqueda y reporte",
            href: "/?item=3",
            links: [
                {
                    text: "Registrar",
                    icon: require("../../images/nota-oficio.svg"),
                    description: "Notas oficio",
                    href: "/NotaOficio/notas",
                },
                {
                    icon: require("../../images/busqueda-nota-oficio.svg"),
                    text: "Busqueda",
                    description: "Notas oficio",
                    href: "/NotaOficioBusqueda/notas",
                },
            ],
        },
        4: {
            text: "Informes",
            icon: require("../../images/informes.svg"),
            description: "Registro busqueda y reporte",
            href: "/?item=4",
            links: [
                {
                    text: "Registrar",
                    icon: require("../../images/informes.svg"),
                    description: "Informes",
                    href: "/ComunicacionesInternas/informes",
                },
                {
                    icon: require("../../images/busqueda-informes.svg"),
                    text: "Busqueda",
                    description: "Informes",
                    href: "/NotaOficioBusqueda/informes",
                },
            ],
        },
        5: {
            text: "Comunicaciónes internas",
            icon: require("../../images/comunicacion.svg"),
            description: "Registro busqueda y reporte",
            href: "/?item=5",
            links: [
                {
                    text: "Registrar",
                    icon: require("../../images/comunicacion.svg"),
                    description: "Comunicaciónes internas",
                    href: "/ComunicacionesInternas/comunicacion",
                },
                {
                    icon: require("../../images/busqueda-comunicacion.svg"),
                    text: "Busqueda",
                    description: "Comunicaciónes internas",
                    href: "/NotaOficioBusqueda/comunicacion",
                },
            ],
        },
        6: {
            icon: require("../../images/reporte.svg"),
            text: "Reporte",
            description: "Reportes de hojas de ruta, notas, etc.",
            href: "/HojaRutaReporte/externa",
        },
        7: {
            icon: require("../../images/reporte-resumen.svg"),
            text: "Reporte Resumen",
            description: "Resumen del reporte de hojas de ruta.",
            href: "/HojaRutaReporteRapido",
        },
    }, window.links);
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
