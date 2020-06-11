<template>
    <panel name="Reporte de asignacion de tareas" class="panel-primary">
        <div class="btn-group" role="group">
            <button type="button" :class="`btn btn-${mensual ? '' : 'outline-'}primary`" @click="mensual=true">Por meses</button>
            <button type="button" :class="`btn btn-${mensual ? 'outline-' : ''}primary`" @click="mensual=false">Por semanas</button>
        </div>
        <div class="d-flex flex-row d-flex justify-content-between">
            <div class="flex-fill">
                <label v-if="error" class="alert alert-danger">{{ error }}</label>
                <reporte-tipo :data="data" :columns="columns">
                    <template v-slot:col(periodo)="{row}">
                        {{ mensual ? moment(`${row.periodo}-01`).format('MMMM / YYYY').toUpperCase() : formatSemana(row.periodo) }}
                    </template>
                    <template v-slot:col(calificacion)="{row}">
                        {{ Number(row.calificacion).toFixed(2) }}
                    </template>
                </reporte-tipo>
            </div>
            <div>
                <chart-bar
                    :data="data"
                    :title="`ASIGNADAS ${mensual?' (POR MES)':' (POR SEMANA)'}`"
                    label-field="periodo"
                    value-field="asignados"
                    :type="mensual ? 'bar' : 'line'"
                />
                <chart-bar
                    :data="data"
                    :title="`ESTADO`"
                    label-field="periodo"
                    :value-field="['pendientes','aprobados','completados']"
                    :colors="['salmon', 'lightblue', 'lightgreen']"
                    type="bar"
                    stacked
                />
            </div>
        </div>
    </panel>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        path: "/reporte4",
        data() {
            return {
                mensual: true,
                error: '',
                reporte: new ApiObject('/api/reporte'),
                data: [],
                columns: [
                    {key: 'periodo', label: 'PERIODO'},
                    {key: 'asignados', label: 'ASIGNADAS'},
                    {key: 'pendientes', label: 'PENDIENTES'},
                    {key: 'aprobados', label: 'APROBADAS'},
                    {key: 'completados', label: 'COMPLETADAS'},
                    {key: 'calificacion', label: 'PROMEDIO CALIFICACIÓN'},
                ],
            };
        },
        methods: {
            formatSemana(periodo) {
                const [year, week] = periodo.split('-');
                return `Semana ${week} / ${year}`;
            },
            runReport() {
                this.error = '';
                this.reporte.callMethod('reporte4', { mensual: this.mensual })
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
        watch: {
            mensual() {
                this.runReport();
            },
        },
    };
</script>
