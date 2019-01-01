<template>
    <div class="content">
        <div class="row">
            <div class="col m-2">
                <table class="w-100" border="1px">
                    <tr>
                        <td valign="top">
                            <div><b>Fecha:</b> <datetime v-model="derivacion.attributes.fecha" :read-only="true"></datetime></div>
                            <div><b>Comentarios:</b> {{derivacion.attributes.comentarios}}</div>
                            <div><b>Destinatario:</b> {{derivacion.attributes.comentarios}}</div>
                            <div><b>Instruccion:</b> {{derivacion.attributes.comentarios}}</div>
                        </td>
                        <td valign="top">
                            <div><b>Firma:</b></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    const errores = {};
    export default {
        path: "/Firmar/Item/:id",
        computed: {
        },
        data() {
            return {
                errores: errores,
                derivacion: new ApiObject('/api/derivacion/' + this.$route.params.id, errores),
            };
        },
        watch: {
            '$route.params.id'() {
                this.derivacion.loadFromAPI('/api/derivacion/' + this.$route.params.id);
            }
        },
    };
</script>
