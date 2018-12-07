<template>
    <div class="content">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-6 col-6 text-center" v-for="link in accessLinks">
                <router-link :to="link.href">
                    <img class="access-link" :src="link.icon"><br>
                    {{link.text}}
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        path: "/",
        data() {
            return {
                accessLinks: [
                    {
                        icon: require("../../images/hoja-de-ruta.svg"),
                        text: "HOJA EXTERNA",
                        href: "/HojaRuta/externa",
                    },
                    {
                        icon: require("../../images/busqueda.svg"),
                        text: "BUSQUEDA EXTERNA",
                        href: "/HojaRutaBusqueda/externa",
                    },
                    {
                        icon: require("../../images/reporte.svg"),
                        text: "REPORTE EXTERNA",
                        href: "/HojaRutaReporte/externa",
                    },
                    {
                        icon: require("../../images/hoja-de-ruta-interna.svg"),
                        text: "HOJA INTERNA",
                        href: "/HojaRuta/interna",
                    },
                    {
                        icon: require("../../images/busqueda-interna.svg"),
                        text: "BUSQUEDA INTERNA",
                        href: "/HojaRutaBusqueda/interna",
                    },
                    {
                        icon: require("../../images/reporte-interna.svg"),
                        text: "REPORTE INTERNA ",
                        href: "/HojaRutaReporte/interna",
                    },
                ]
            };
        }
    };
</script>

<style lang="scss">
    .access-link {
        margin-top: 1em;
        width: 12em;
    }
</style>
