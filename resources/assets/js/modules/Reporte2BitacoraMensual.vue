<template>
    <panel name="Bitacora Mensual de Tareas" class="panel-primary">
        <label v-if="error" class="alert alert-danger">{{ error }}</label>
        <reporte-tipo :data="data" :columns="columns">
            <template v-slot:col(periodo)="{row}">
                {{ moment(`${row.periodo}-01`).format('MMMM / YYYY').toUpperCase() }}
            </template>
        </reporte-tipo>
    </panel>
</template>

<script>
    export default {
        path: "/reporte2/bitacora/tareas",
        data() {
            return {
                error: '',
                reporte: new ApiObject('/api/reporte'),
                data: [],
                columns: [
                    {key: 'periodo', label: 'PERIODO'},
                    {key: 'asignados', label: 'ASIGNADAS'},
                    {key: 'completados', label: 'ATENDIDAS'},
                    {key: 'pendientes', label: 'PENDIENTES'},
                ],
            };
        },
        methods: {
            runReport() {
                this.error = '';
                this.reporte.callMethod('reporte2bitacora_mensual', {})
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
