<template>
    <panel name="Reporte tareas" class="panel-primary">
        <label v-if="error" class="alert alert-danger">{{ error }}</label>
        <reporte-tipo :data="data" :columns="columns">
            <template v-slot:col(periodo)="{row}">
                <span class="text-uppercase">
                    {{ moment(`${row.periodo}-01`).format('MMMM / YYYY') }}
                </span>
            </template>
        </reporte-tipo>
    </panel>
</template>

<script>
    export default {
        path: "/reporte1/tareas",
        data() {
            return {
                error: '',
                reporte: new ApiObject('/api/reporte'),
                data: [],
                columns: [
                    {key: 'periodo', label: 'Periodo'},
                    {key: 'registradas', label: 'TAREAS REGISTRADAS'},
                    {key: 'concluidas', label: 'TAREAS CONCLUIDAS'},
                ],
            };
        },
        methods: {
            runReport() {
                this.error = '';
                this.reporte.callMethod('reporte1tareas', {})
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
