<template>
    <panel name="Cantidad de Hojas de Ruta Concluidas en un periodo de tiempo" class="panel-primary">
        <label v-if="error" class="alert alert-danger">{{ error }}</label>
        <reporte-tipo :data="data" :columns="columns">
            <template v-slot:col(periodo)="{row}">
                {{ moment(`${row.periodo}-01`).format('MMMM / YYYY') }}
            </template>
        </reporte-tipo>
    </panel>
</template>

<script>
    export default {
        path: "/reporte1/concluidas",
        data() {
            return {
                error: '',
                reporte: new ApiObject('/api/reporte'),
                data: [],
                columns: [
                    {key: 'periodo', label: 'Periodo'},
                    {key: 'cantidad', label: 'HOJAS DE RUTA CONCLUIDAS'},
                ],
            };
        },
        methods: {
            runReport() {
                this.error = '';
                this.reporte.callMethod('reporte1concluidas', {})
                    .then(response => {
                       this.data = response.data.response;
                    })
                    .catch(error => {
                        this.error = error.message;
                    });
            },
        },
        mounted() {
            this.runReport();
        },
    };
</script>
