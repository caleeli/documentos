<template>
    <panel :name="'REPORTE'" class="panel-primary">
        <div v-if='data.attributes' class="container">
            <error v-model="errores" property="message"></error>
            <div class="form-group row">
                <div :class="colLabel"><label>Tipo de búsqueda:</label></div>
                <div :class="colField">
                    <div class="checkbox" v-for="tipo in tipos">
                        <label>
                            <input type="checkbox" name="tipo_busqueda"
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
                    <suggest v-model="data.attributes.procedencia"
                             :data="procedencias"
                             id-field="attributes.nombre_completo"
                             filter-by="attributes.nombre_completo">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.nombre_completo)" style="font-size: 1rem"></span>
                        </template>
                    </suggest>
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
                    <input class="form-control" type="text" v-model="data.attributes.gestion_hasta" />
                    <error v-model="errores" property="errors.gestion_hasta"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Destinatario:</label></div>
                <div :class="colField">
                    <select-box :data="destinatarios" v-model="data.attributes.destinatario" :multiple="true"
                        filter-by="attributes.nombre_completo">
                        <template slot-scope="{row,format,remove}">
                            <!-- Used to render the selected items -->
                            <template v-if="row instanceof Array">
                                <span v-for="item in row" class="badge badge-light selected-item" v-html="format(item.attributes.nombre_completo)" @click="remove(item)"></span>
                            </template>
                            <!-- Used to render the items in the selection list -->
                            <template v-else>
                                <span v-html="format(row.attributes.nombre_completo)" style="font-size: 1rem"></span>
                            </template>
                        </template>
                    </select-box>
                    <error v-model="errores" property="errors.destinatario"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Clasificación:</label></div>
                <div :class="colField">
                    <div class="radio" v-for="clasificacion in clasificacionHojasRuta">
                        <div class="radio col-6">
                            <label>
                                <input type="radio" name="hoja_edit_tipo"
                                    :value="clasificacion.attributes.sigla"
                                    v-model="data.attributes.tipo_tarea"
                                    @click="clickRadio(data.attributes, 'tipo_tarea', clasificacion.attributes.sigla)">
                                {{clasificacion.attributes.nombre}}
                            </label>
                        </div>
                        <div class="col-6"
                                 v-show="data.attributes.tipo_tarea===clasificacion.attributes.sigla"
                                 v-if="clasificacion.relationships.subclases && clasificacion.relationships.subclases.length">
                                <select class="form-control input-sm" v-model="data.attributes.subtipo_tarea">
                                    <option value=""></option>
                                    <option v-for="subclase in clasificacion.relationships.subclases"
                                            :value="subclase.id">{{subclase.attributes.nombre}}</option>
                                </select>
                        </div>
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
                    <button type="button" class="btn btn-primary" @click="generarPreview">Vista previa</button>
                    <button type="button" class="btn btn-primary" @click="generarExcel">Exportar Excel</button>
                    <button type="button" class="btn btn-primary" @click="generarPDF">Exportar PDF</button>
                </div>
            </div>
            <error v-model="reportErrors" property="message"></error>
            <grid v-model="report">
                <template slot="header">
                    <th width="4%">#</th>
                    <th width="6%">Tipo</th>
                    <th width="8%">Nro Control</th>
                    <th width="10%">Fecha derivación</th>
                    <th width="14%">Referencia</th>
                    <th width="14%">Destinatario</th>
                    <th width="14%">Procecendia</th>
                    <th width="10%">Fecha recepción</th>
                    <th width="10%">Conclusión</th>
                    <th width="10%">Instrucción</th>
                </template>
                <tr slot-scope="{row, options, format}">
                    <td>{{row.num}}</td>
                    <td>{{row.tipo_hr}}</td>
                    <td>{{row.numero}}</td>
                    <td><datetime v-model="row.derivacion_fecha" :read-only="true" type="date"/></td>
                <td>{{row.referencia}}</td>
                <td>{{row.destinatario}}</td>
                <td>{{row.procedencia}}</td>
                <td><datetime v-model="row.fecha_recepcion" :read-only="true" type="date"/></td>
                <td><datetime v-model="row.fecha_conclusion" :read-only="true" type="date"/></td>
                <td>{{row.instruccion}}</td>
                </tr>
            </grid>
        </div>
    </panel>
</template>

<script>
    export default {
        props: {
            type: String,
        },
        methods: {
            clickRadio(attributes, name, value) {
                if (attributes[name] === value) {
                    this.$set(attributes, name, '');
                }
            },
            getProcedencias() {
                this.data.callMethod('getProcedencias')
                    .then(response => {
                        this.$set(this, 'procedencias', response.data.response);
                    });
            },
            getIdURL() {
                return isNaN(this.type)
                        ? 'create'
                        : this.type;
            },
            generarReporte() {
                this.data.postToAPI("/api/reporte").then((response) => {
                    this.$router.push({params: {id: response.data.data.id}});
                });
            },
            generarPreview() {
                this.data.postToAPI("/api/reporte").then((response) => {
                    window.open('/reporte/' + response.data.data.id + '/html');
                });
            },
            generarExcel() {
                this.data.postToAPI("/api/reporte").then((response) => {
                    window.open('/reporte/' + response.data.data.id + '/excel');
                });
            },
            generarPDF() {
                this.data.postToAPI("/api/reporte").then((response) => {
                    window.open('/reporte/' + response.data.data.id + '/pdf');
                });
            },
        },
        data() {
            const errores = {};
            const reportErrors = {};
            return {
                report: [],
                data: new ApiObject('/api/reportes/' + this.getIdURL(), errores)
                        //.loadFromAPI()
                        .onupdate(data => {
                            if (data.id) {
                                data.callMethod('generar')
                                        .then(response => {
                                            this.report.splice(0);
                                            response.data.response.forEach(item => {
                                                this.report.push(item);
                                            });
                                        });
                            }
                        }),
                errores: errores,
                reportErrors: reportErrors,
                procedencias: [], //new ApiArray('/api/empresas'),
                destinatarios: new ApiArray('/api/users'),
                clasificacionHojasRuta: new ApiArray('/api/hoja_ruta_clasificacion?include=subclases'),
                tipos: [
                    {attributes: {sigla: 'externa', nombre: 'HR Externa'}},
                    {attributes: {sigla: 'interna', nombre: 'HR Interna'}},
                    {attributes: {sigla: 'solicitud', nombre: 'Solicitud y/o Denuncias'}},
                    {attributes: {sigla: 'notas', nombre: 'Notas oficio'}},
                    {attributes: {sigla: 'comunicacion', nombre: 'Comunicación Interna'}},
                    {attributes: {sigla: 'informes', nombre: 'Informes'}},
                ],
                tiposReporte: [
                    /*{attributes: {sigla: 'hoja_ruta', nombre: 'Por Hoja de Ruta'}},
                    {attributes: {sigla: 'derivacion', nombre: 'Por Derivación'}},
                    {attributes: {sigla: 'detallada', nombre: 'Detallada'}},*/
                    {attributes: {sigla: 'pendientes', nombre: 'Pendientes'}},
                    {attributes: {sigla: 'concluidos', nombre: 'Concluidos'}},
                    {attributes: {sigla: 'destinatario', nombre: 'Destinatario'}},
                ],
            };
        },
        watch: {
            'type'() {
                this.data.loadFromAPI('/api/reportes/' + this.getIdURL());
            }
        },
        mounted() {
            this.getProcedencias();
        },
    };
</script>

<style lang="scss">
    .anexos tr td {
    }
    .anexos tr td small {
    }
    .selected-item {
        font-size: 1rem;
        pointer-events: all!important;
        cursor: pointer;
    }
    .selected-item:hover {
        text-decoration: underline;
    }
</style>
