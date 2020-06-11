<template>
    <panel name="Reporte 3 mensual" class="panel-primary">
        <label v-if="error" class="alert alert-danger">{{ error }}</label>
        <reporte-tipo :data="data" :columns="columns" :show-rule="showRule">
            <template v-slot:col(periodo)="{row}">
                <span v-if="row.subreport" class="text-uppercase ml-4">
                    {{ moment(`${row.periodo}-01`).format('MMMM / YYYY') }}
                </span>
                <span v-else class="text-uppercase">
                    <b>{{ row.usuario }}</b>
                </span>
            </template>
            <template v-slot:col(aprobados)="{row}">
                <span v-if="row.subreport">{{ row.aprobados }}</span>
                <b v-else>{{ row.aprobados }}</b>
            </template>
            <template v-slot:col(pendientes)="{row}">
                <span v-if="row.subreport">{{ row.pendientes }}</span>
                <b v-else>{{ row.pendientes }}</b>
            </template>
            <template v-slot:col(completados)="{row}">
                <span v-if="row.subreport">{{ row.completados }}</span>
                <b v-else>{{ row.completados }}</b>
            </template>
        </reporte-tipo>
    </panel>
</template>

<script>
    export default {
        path: "/reporte3usuario",
        data() {
            return {
                error: '',
                reporte: new ApiObject('/api/reporte'),
                data: [],
                columns: [
                    {key: 'periodo', label: 'PERIODO'},
                    {key: 'aprobados', label: 'SUPERVISADAS'},
                    {key: 'pendientes', label: 'PENDIENTES'},
                    {key: 'completados', label: 'ATENDIDAS'},
                ],
            };
        },
        methods: {
            loadSubReport(row) {
                if (row.subreport) return;
                this.error = '';
                this.reporte.callMethod('reporte3usuario_mes', { usuario: row.user_id })
                    .then(response => {
                        const index = this.data.indexOf(row);
                        this.data.splice(index + 1,0, ...response.data.response);
                    })
                    .catch(error => {
                        this.error = error.message;
                        throw error;
                    });
            },
            runReport() {
                this.error = '';
                this.reporte.callMethod('reporte3usuario', {})
                    .then(response => {
                        this.data = response.data.response;
                        this.data.forEach(row => this.loadSubReport(row));
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
