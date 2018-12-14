<template>
    <div class="content">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-6 col-6 text-center" v-for="link in accessLinks">
                <router-link v-if="link.href" :to="link.href">
                    <img class="access-link" :src="link.icon"><br>
                    {{link.text}}
                </router-link>
                <a v-if="link.handler" href="javascript:void(0)" @click="link.handler">
                    <img class="access-link" :src="link.icon"><br>
                    {{link.text}}
                </a>
                <a v-if="link.macro" href="javascript:void(0)" @click="runMacro(link.macro)">
                    <img class="access-link" :src="link.icon"><br>
                    {{link.text}}
                </a>
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
                    icon: require("../../images/carpetas.svg"),
                    text: "Iniciar Revision de Carpetas de Credito",
                    handler: function() {
                        axios.get('/api/revision_carpetas/call').then(() => {
                            window.location.reload();
                        });
                    },
                },
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
            ];
            links.unshift(...window.tasks);
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
        margin-top: 1em;
        width: 12em;
    }
</style>
