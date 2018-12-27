<template>
    <div class="content" style="padding:1em; width: 100vw;">
        <div class="row">
            <!-- div class="col-lg-3 col-md-4 col-sm-6 col-12 text-center">
                <char-asignaciones></char-asignaciones>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 text-center">
                <d3-line></d3-line>
            </div -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 text-center" v-for="item in accessLinks">
                <dashboard-item :value="item">
                    <li v-for="link in item.links">
                    <router-link v-if="link.href" :to="link.href">
                        <img class="access-link" :src="link.icon">
                        {{link.text}}
                    </router-link>
                    <a v-if="link.handler" href="javascript:void(0)" @click="link.handler">
                        <img class="access-link" :src="link.icon">
                        {{link.text}}
                    </a>
                    <a v-if="link.macro" href="javascript:void(0)" @click="runMacro(link.macro)">
                        <img class="access-link" :src="link.icon">
                        {{link.text}}
                    </a>
                    </li>
                </dashboard-item>
            </div>
        </div>
    </div>
</template>

<script>
    require("../../images/carpeta.svg");
    export default {
        path: "/",
        data() {
            const links = [
                {
                    text: "Registrar",
                    icon: require("../../images/hoja-de-ruta.svg"),
                    description: "Hoja de ruta externa",
                    href: "/HojaRuta/externa",
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
                {
                    text: "Registrar",
                    icon: require("../../images/hoja-de-ruta-interna.svg"),
                    description: "Hoja de ruta interna",
                    href: "/HojaRuta/interna",
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
                {
                    text: "Registrar",
                    icon: require("../../images/hoja-de-ruta-solicitud.svg"),
                    description: "Solicitudes y denuncia",
                    href: "/HojaRuta/solicitud",
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
                {
                    text: "Registrar",
                    icon: require("../../images/nota-oficio.svg"),
                    description: "Notas oficio",
                    href: "/NotaOficio/create",
                },
                {
                    icon: require("../../images/busqueda-nota-oficio.svg"),
                    text: "Busqueda",
                    description: "Notas oficio",
                    href: "/NotaOficioBusqueda",
                },
                {
                    icon: require("../../images/reporte-nota-oficio.svg"),
                    text: "Reporte",
                    description: "Notas oficio",
                    href: "/NotaOficioReporte",
                },
                {
                    text: "Registrar",
                    icon: require("../../images/hoja-de-ruta-interna.svg"),
                    description: "Comunicación interna e informes",
                    href: "/HojaRuta/interna",
                },
                {
                    icon: require("../../images/busqueda-interna.svg"),
                    text: "Busqueda",
                    description: "Comunicación interna e informes",
                    href: "/HojaRutaBusqueda/interna",
                },
                {
                    icon: require("../../images/reporte-interna.svg"),
                    text: "Reporte",
                    description: "Comunicación interna e informes",
                    href: "/HojaRutaReporte/interna",
                },
            ];
            return {
                accessLinks: links,
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
            }
        }
    };
</script>

<style lang="scss">
    .access-link {
        width: 1em;
    }
</style>
