<template>
    <div class="content">
        <div class="row">
            <div class="col m-2">
                <table v-if="derivacion.attributes" class="w-100" border="1px">
                    <tr>
                        <th>Fecha:</th><td><datetime v-model="derivacion.attributes.fecha" :read-only="true"></datetime></td>
                    </tr>
                    <tr>
                        <th>Comentarios:</th><td>{{derivacion.attributes.comentarios}}</td>
                    </tr>
                    <tr>
                        <th>Destinatario:</th><td>{{derivacion.attributes.destinatario}}</td>
                    </tr>
                    <tr>
                        <th>Instruccion:</th><td>{{derivacion.attributes.instruccion}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col m-2">
                <div><b>Firma:</b></div>
                <button class="btn btn-success" @click="firmar">Solicitar firma</button>
                <drawing-board></drawing-board>
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
        methods: {
            firmar(){
                window.document.body.requestFullscreen();
            }
        }
    };
</script>
