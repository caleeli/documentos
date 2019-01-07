<template>
    <desktop :links="links">
    </desktop>
</template>

<script>
    export default {
        path: "/Firmar/Lista",
        beforeRouteLeave(to, from, next) {
            console.log('salio');
            next();
        },
        computed: {
            links() {
                const links = [];
                const instance = this.$route.query.instance;
                const token = this.$route.query.token;
                this.pendientes.forEach(item => {
                    links.push({
                        text: item.attributes.destinatario,
                        description: item.attributes.comentarios + '\n' + item.attributes.instruccion,
                        href: {
                            path: '/Process/Complete/' + instance + '/' + token,
                            query: {
                                item: item.attributes.id,
                            },
                        },
                        icon: '/images/processes/FirmaHojaRuta/firmas.svg',
                    });
                });
                return links;
            }
        },
        data() {
            return {
                pendientes: new ApiArray('/api/derivacion?sort=-id&filter[]=whereNull,firma&per_page=200')
            };
        },
    };
</script>
