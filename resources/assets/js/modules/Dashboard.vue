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
                {
                    icon: require("../../images/reporte.svg"),
                    text: "Reporte",
                    description: "Hoja de ruta externa",
                    href: "/HojaRutaReporte/externa",
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
                {
                    icon: require("../../images/reporte-interna.svg"),
                    text: "Reporte",
                    description: "Hoja de ruta interna",
                    href: "/HojaRutaReporte/interna",
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
                {
                    icon: require("../../images/reporte-solicitud.svg"),
                    text: "Reporte",
                    description: "Solicitudes y denuncia",
                    href: "/HojaRutaReporte/solicitud",
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
                {
                    icon: require("../../images/reporte-nota-oficio.svg"),
                    text: "Reporte",
                    description: "Notas oficio",
                    href: "/HojaRutaReporte/notas",
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
                {
                    icon: require("../../images/reporte-informes.svg"),
                    text: "Reporte",
                    description: "Informes",
                    href: "/HojaRutaReporte/informes",
                },
            ],
        },
        5: {
            text: "Comunicación interna e informes",
            icon: require("../../images/comunicacion.svg"),
            description: "Registro busqueda y reporte",
            href: "/?item=5",
            links: [
                {
                    text: "Registrar",
                    icon: require("../../images/comunicacion.svg"),
                    description: "Comunicación interna e informes",
                    href: "/ComunicacionesInternas/comunicacion",
                },
                {
                    icon: require("../../images/busqueda-comunicacion.svg"),
                    text: "Busqueda",
                    description: "Comunicación interna e informes",
                    href: "/NotaOficioBusqueda/comunicacion",
                },
                {
                    icon: require("../../images/reporte-comunicacion.svg"),
                    text: "Reporte",
                    description: "Comunicación interna e informes",
                    href: "/HojaRutaReporte/comunicacion",
                },
            ],
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
