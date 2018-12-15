<template>
    <div class="content" style="padding:1em; width: 100vw;">
        <div class="row">
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
                    icon: require("../../images/carpetas.svg"),
                    text: "Iniciar Revision de Carpetas de Credito",
                    handler: function() {
                        axios.get('/api/revision_carpetas/call').then(() => {
                            window.location.reload();
                        });
                    },
                },
                {
                    text: "HOJA EXTERNA",
                    icon: require("../../images/hoja-de-ruta.svg"),
                    description: "Registro, busqueda y reportes",
                    links: [
                        {
                            icon: require("../../images/hoja-de-ruta.svg"),
                            text: "Registrar",
                            href: "/HojaRuta/externa",
                        },
                        {
                            icon: require("../../images/busqueda.svg"),
                            text: "Busqueda",
                            href: "/HojaRutaBusqueda/externa",
                        },
                        {
                            icon: require("../../images/reporte.svg"),
                            text: "Reporte",
                            href: "/HojaRutaReporte/externa",
                        },
                    ],
                },
                {
                    text: "HOJA INTERNA",
                    icon: require("../../images/hoja-de-ruta-interna.svg"),
                    description: "Registro, busqueda y reportes",
                    links: [
                        {
                            icon: require("../../images/hoja-de-ruta-interna.svg"),
                            text: "Registrar",
                            href: "/HojaRuta/interna",
                        },
                        {
                            icon: require("../../images/busqueda-interna.svg"),
                            text: "Busqueda",
                            href: "/HojaRutaBusqueda/interna",
                        },
                        {
                            icon: require("../../images/reporte-interna.svg"),
                            text: "Reporte",
                            href: "/HojaRutaReporte/interna",
                        },
                    ],
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
        width: 1em;
    }
</style>
