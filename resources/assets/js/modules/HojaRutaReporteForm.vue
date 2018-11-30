<template>
    <panel :name="'REPORTE'" class="panel-primary">
        <div v-if='data.attributes' class="container">
            <div class="row">
                <div class="col-12"><h4>{{titulo}}</h4></div>
            </div>
            <error v-model="errores" property="message"></error>
            <div class="form-group row">
                <div :class="colLabel"><label>Tipo de búsqueda:</label></div>
                <div :class="colField">
                    <div class="radio" v-for="tipo in tipos">
                        <label>
                            <input type="radio" name="tipo_busqueda"
                                   :value="tipo.attributes.sigla"
                                   v-model="data.attributes.tipo">
                            {{tipo.attributes.nombre}}
                        </label>
                    </div>
                    <error v-model="errores" property="errors.tipo"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Fecha de recepción:</label></div>
                <div :class="colField2">
                    <datetime type="date" v-model="data.attributes.recepcion_desde" />
                    <error v-model="errores" property="errors.recepcion_desde"></error>
                </div>
                <div :class="colField2">
                    <datetime type="date" v-model="data.attributes.recepcion_hasta" />
                    <error v-model="errores" property="errors.recepcion_hasta"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Palabra clave Referencia:</label></div>
                <div :class="colField">
                    <input class="form-control" v-model="data.attributes.referencia">
                    <error v-model="errores" property="errors.referencia"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Procedencia:</label></div>
                <div :class="colField">
                    <input class="form-control" v-model="data.attributes.procedencia">
                    <error v-model="errores" property="errors.procedencia"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>N° de control:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.nro_de_control" />
                    <error v-model="errores" property="errors.nro_de_control"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Fecha de conclusión:</label></div>
                <div :class="colField2">
                    <datetime type="date" v-model="data.attributes.conclusion_desde" />
                    <error v-model="errores" property="errors.conclusion_desde"></error>
                </div>
                <div :class="colField2">
                    <datetime type="date" v-model="data.attributes.conclusion_hasta" />
                    <error v-model="errores" property="errors.conclusion_hasta"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Gestión:</label></div>
                <div :class="colField2">
                    <input class="form-control" type="text" v-model="data.attributes.gestion_desde" />
                    <error v-model="errores" property="errors.gestion_desde"></error>
                </div>
                <div :class="colField2">
                    <datetime type="date" v-model="data.attributes.gestion_hasta" />
                    <error v-model="errores" property="errors.gestion_hasta"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Destinatario:</label></div>
                <div :class="colField">
                    <select-box :data="destinatarios" v-model="data.attributes.destinatario"
                        id-field="attributes.nombre_completo"
                        filter-by="attributes.nombre_completo">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.nombre_completo)" style="font-size: 1rem"></span>
                        </template>
                    </select-box>
                    <error v-model="errores" property="errors.destinatario"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Clasificación:</label></div>
                <div :class="colField">
                    <div class="radio" v-for="clasificacion in clasificacionHojasRuta">
                        <label>
                            <input type="radio" name="hoja_edit_tipo"
                                   :value="clasificacion.attributes.sigla"
                                   v-model="data.attributes.tipo_tarea">
                            {{clasificacion.attributes.nombre}}
                        </label>
                    </div>
                    <error v-model="errores" property="errors.tipo_tarea"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Tipo de reporte:</label></div>
                <div :class="colField">
                    <div class="radio" v-for="tipo in tiposReporte">
                        <label>
                            <input type="radio" name="tipo_reporte"
                                   :value="tipo.attributes.sigla"
                                   v-model="data.attributes.tipo_reporte">
                            {{tipo.attributes.nombre}}
                        </label>
                    </div>
                    <error v-model="errores" property="errors.tipo_reporte"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"></div>
                <div :class="colField">
                    <button type="button" class="btn btn-primary" @click="generarReporte">Generar Reporte</button>
                    <button type="button" class="btn btn-primary" @click="generarExcel">Exportar Excel</button>
                </div>
            </div>
        </div>
    </panel>
</template>

<script>
    export default {
        path: "/HojaRuta/:id",
        computed: {
            titulo() {
                return 'REPORTE - ' + this.data.attributes.tipo;
            },
        },
        methods: {
            generarReporte() {
            },
            generarExcel() {
            },
        },
        data() {
            const errores = {};
            return {
                data: new ApiObject('/api/reportes/create', errores).loadFromAPI(),
                errores: errores,
                procedencias: new ApiArray('/api/empresas'),
                destinatarios: new ApiArray('/api/users'),
                clasificacionHojasRuta: new ApiArray('/api/hoja_ruta_clasificacion'),
                tipos: [
                    {attributes: {sigla: 'externa', nombre: 'HR Externa'}},
                    {attributes: {sigla: 'interna', nombre: 'HR Interna'}},
                    {attributes: {sigla: 'solicitud', nombre: 'Solicitud y/o Denuncias'}},
                    {attributes: {sigla: 'notas', nombre: 'Notas oficio'}},
                    {attributes: {sigla: 'comunicacion', nombre: 'Comunicación Interna'}},
                    {attributes: {sigla: 'informes', nombre: 'Informes'}},
                ],
                tiposReporte: [
                    {attributes: {sigla: 'hoja_ruta', nombre: 'Por Hoja de Ruta'}},
                    {attributes: {sigla: 'derivacion', nombre: 'Por Derivación'}},
                    {attributes: {sigla: 'detallada', nombre: 'Detallada'}},
                ],
            };
        },
        watch: {
            '$route.params.id'() {
                this.data.loadFromAPI('/api/hoja_rutas/' + this.getIdURL());
            }
        }
    };
</script>

<style lang="scss">
    .anexos tr td {
    }
    .anexos tr td small {
    }
</style>
