<template>
    <desktop :links="links">
    </desktop>
</template>

<script>
    import task from '../mixins/task.js';
    export default {
        path: "/Firmar/Lista",
        mixins: [task],
        computed: {
            links() {
                ;
                const links = [];
                this.pendientes.forEach(item => {
                    links.push({
                        text: item.attributes.destinatario,
                        description: item.attributes.comentarios + '\n' + item.attributes.instruccion,
                        href: this.$processCompleteRoute({item: item.attributes.id}),
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
