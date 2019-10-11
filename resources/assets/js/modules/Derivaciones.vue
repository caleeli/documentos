<template>
    <div>
        <div class="row">
            <div class="col-12">
                <br><hr>
                <h4>Derivaciones</h4>
            </div>
        </div>
        <error v-model="erroresDerivacion" property="message"></error>
        <div class="container" v-if="derivacion.attributes">
            <div class="form-group row">
                <div :class="colLabel"><label>Fecha de derivación:</label></div>
                <div :class="colField">
                    <datetime type="date" :read-only="!pendiente" v-model="derivacion.attributes.fecha" />
                    <error v-model="erroresDerivacion" property="errors.fecha"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Comentarios:</label></div>
                <div :class="colField">
                    <text-box :readonly="!pendiente" v-model="derivacion.attributes.comentarios" :reference="referenciarNota">
                        <template slot="dropdown" slot-scope="{code,select}">
                            <grid v-model="notas" :filter="code" :without-navbar="true"
                                  filter-by="attributes.nro_nota
                                  attributes.referencia">
                                <tr slot-scope="{row, options, format}" @click="select(row)">
                                    <td v-html="format(row.attributes.nro_nota)"></td>
                                    <td v-html="format(row.attributes.referencia)"></td>
                                </tr>
                            </grid>
                        </template>
                    </text-box>
                    <error v-model="erroresDerivacion" property="errors.comentarios"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Destinatarios (*):</label></div>
                <div :class="colField">
                    <select-box :readonly="!pendiente" :data="destinatarios" v-model="derivacion.attributes.destinatarios"
                        :multiple="true"
                        @change="seleccionaDestinatario"
                        id-field="id"
                        filter-by="attributes.nombre_completo">
                        <template slot-scope="{row,format,remove}">
                            <span v-if="remove" class="selected-item badge badge-light mr-1">
                                <span v-html="row.attributes.nombre_completo" style="font-size: 1rem" @click="remove(row)"></span>
                            </span>
                            <span v-else v-html="format(row.attributes.nombre_completo)" style="font-size: 1rem"></span>
                        </template>
                    </select-box>
                    <error v-model="erroresDerivacion" property="errors.destinatarios"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Instrucción:</label></div>
                <div :class="colField">
                    <select-box :readonly="!pendiente" :data="getInstruccionPorSigla" v-model="derivacion.attributes.instruccion" 
                        id-field="attributes.nombre"
                        filter-by="attributes.sigla,attributes.nombre">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.nombre)" style="font-size: 1rem"></span>
                        </template>
                    </select-box>
                    <error v-model="erroresDerivacion" property="errors.instruccion"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Dias plazo:</label></div>
                <div :class="colField">
                    <input :readonly="!pendiente" class="form-control" type="number" v-model="derivacion.attributes.dias_plazo" />
                    <error v-model="erroresDerivacion" property="errors.dias_plazo"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"></div>
                <div :class="colField">
                    <button :disabled="!pendiente" type="button" class="btn btn-primary" @click="registrarDerivacion">Registrar</button>
                    <button v-if="pendiente" type="button" class="btn btn-primary" @click="terminarHojaRuta">Terminar</button>
                    <button v-if="!pendiente" type="button" class="btn btn-primary" @click="habilitarHojaRuta">Habilitar</button>
                </div>
            </div>
        </div>
        <grid v-model="derivaciones">
            <template slot="header">
                <th width="10%">Fecha de derivación</th>
                <th width="30%">Destinatario</th>
                <th width="30%">Comentarios</th>
                <th width="20%">Instrucción</th>
                <th width="10%">Días plazo</th>
            </template>
            <tr slot-scope="{row, options, format}">
            <template v-if="row.edit">
                <td>
                <datetime v-model="row.attributes.fecha" :read-only="false" type="date"/>
                <error v-model="erroresDerivacionEdit" property="errors.fecha"></error>
                </td>
                <td>
                <select-box :data="destinatarios" v-model="row.attributes.destinatarios"
                    :multiple="true"
                    @change="seleccionaEditDestinatario($event, row)"
                    id-field="id"
                    filter-by="attributes.nombre_completo">
                    <template slot-scope="{row,format,remove}">
                        <span v-if="remove" class="selected-item badge badge-light mr-1">
                            <span v-html="row.attributes.nombre_completo" style="font-size: 0.6rem" @click="remove(row)"></span>
                        </span>
                        <span v-else v-html="format(row.attributes.nombre_completo)" style="font-size: 1rem"></span>
                    </template>
                </select-box>
                <error v-model="erroresDerivacionEdit" property="errors.destinatario"></error>
                </td>
                <td>
                <text-box v-model="row.attributes.comentarios" :reference="referenciarNota">
                    <template slot="dropdown" slot-scope="{code,select}">
                        <grid v-model="notas" :filter="code" :without-navbar="true"
                              filter-by="attributes.nro_nota
                              attributes.referencia">
                            <tr slot-scope="{row, options, format}" @click="select(row)">
                                <td v-html="format(row.attributes.nro_nota)"></td>
                                <td v-html="format(row.attributes.referencia)"></td>
                            </tr>
                        </grid>
                    </template>
                </text-box>
                <error v-model="erroresDerivacionEdit" property="errors.comentarios"></error>
                </td>
                <td>
                <select-box :data="getInstruccionPorSigla" v-model="row.attributes.instruccion" 
                    id-field="attributes.nombre"
                    filter-by="attributes.sigla,attributes.nombre">
                    <template slot-scope="{row,format}">
                        <span v-html="format(row.attributes.nombre)" style="font-size: 1rem"></span>
                    </template>
                </select-box>
                <error v-model="erroresDerivacionEdit" property="errors.instruccion"></error>
                </td>
                <td>
                    <input class="form-control" type="number" v-model="row.attributes.dias_plazo" />
                    <error v-model="erroresDerivacionEdit" property="errors.dias_plazo"></error>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="actualizaDerivacion(row)"><i class="fas fa-check"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="deshacerCambiosDerivacion(row)"><i class="fas fa-undo"></i></button>
                </td>
            </template>
            <template v-else>
                <td><datetime v-model="row.attributes.fecha" :read-only="true" type="date"/></td>
                <td v-html="format(row.attributes.destinatario)"></td>
                <td v-html="format(row.attributes.comentarios)"></td>
                <td>{{row.attributes.instruccion}}</td>
                <td>{{row.attributes.dias_plazo}}</td>
                <td>
                    <button type="button" class="btn btn-sm" @click="editarDerivacion(row)"><i class="fas fa-pen"></i></button>
                </td>
                <td>
                    <button type="button" class="btn btn-sm" @click="eliminarDerivacion(row)"><i class="fa fa-trash"></i></button>
                </td>
            </template>
            </tr>
        </grid>
    </div>
</template>

<script>
    export default {
        props: {
            hojaRuta: Object,
            type: String,
        },
        computed: {
            pendiente() {
                return !this.hojaRuta.attributes.fecha_conclusion;
            },
            getInstruccionPorSigla() {
                let sigla = this.hojaRuta.attributes.tipo_tarea;
                let instruccion = this.instrucciones.filter(
                    function(e) {
                        return e.attributes.sigla == sigla
                    }
                );
                return instruccion;
            },
        },
        methods: {
            editarDerivacion(row) {
                this.$set(row, 'edit', true);
            },
            deshacerCambiosDerivacion(row) {
                this.derivaciones.loadFromAPI();
                row.edit = false;
            },
            actualizaDerivacion(row) {
                this.$set(this.derivacionEdit, 'attributes', row.attributes);
                this.derivacionEdit.putToAPI('/api/derivacion/' + row.id).then(() => {
                    row.edit = false;
                });
            },
            seleccionaEditDestinatario(selected, row) {
                const nombres = [];
                selected.forEach((row) => {
                    nombres.push(row.attributes.nombre_completo);
                });
                row.attributes.destinatario = nombres.join(', ');
            },
            seleccionaDestinatario(selected) {
                const nombres = [];
                selected.forEach((row) => {
                    nombres.push(row.attributes.nombre_completo);
                });
                this.derivacion.attributes.destinatario = nombres.join(', ');
            },
            habilitarHojaRuta() {
                this.hojaRuta.attributes.fecha_conclusion = null;
                this.hojaRuta.putToAPI('/api/hoja_ruta/' + this.hojaRuta.id).then((response) => {
                });
            },
            terminarHojaRuta() {
                this.derivacion.attributes.hoja_ruta_id = this.hojaRuta.id;
                this.derivacion.postToAPI('/api/hoja_ruta' + '/' + this.hojaRuta.id + '/derivacion').then(() => {
                        this.derivaciones.loadFromAPI();
                        this.derivacion.loadFromAPI();
                    });
                this.hojaRuta.attributes.fecha_conclusion = moment().format('YYYY-MM-DD');
                this.hojaRuta.putToAPI('/api/hoja_ruta/' + this.hojaRuta.id).then((response) => {
                    this.$router.push({path: '/HojaRutaBusqueda'});
                });
            },
            registrarDerivacion() {
                this.derivacion.attributes.hoja_ruta_id = this.hojaRuta.id;
                this.derivacion.postToAPI('/api/hoja_ruta' + '/' + this.hojaRuta.id + '/derivacion').then(() => {
                        this.derivaciones.loadFromAPI();
                        this.derivacion.loadFromAPI();
                    });
            },
            referenciarNota(nota) {
                return nota.attributes.nro_nota + " " + nota.attributes.referencia;
            },
            eliminarDerivacion(row) {
                var self = this;
                if (confirm("¿Desea eliminar la derivacion " + row.attributes.id + "?")) {
                    this.derivacion.deleteToAPI('/api/derivacion/' + row.attributes.id).then(() => {
                        this.derivaciones.loadFromAPI();
                    });
                }
            },
        },
        data() {
            const erroresDerivacion = {};
            const erroresDerivacionEdit = {};
            return {
                notas: new ApiArray('/api/notas_oficio?sort=-id&per_page=2000'),
                destinatarios: new ApiArray('/api/users'),
                derivacionEdit: new ApiObject('/api/derivacion/create', erroresDerivacionEdit),
                derivacion: new ApiObject('/api/derivacion/create', erroresDerivacion),
                erroresDerivacion: erroresDerivacion,
                erroresDerivacionEdit: erroresDerivacionEdit,
                instrucciones: new ApiArray('/api/instruccion'),
                derivaciones: new ApiArray('/api/hoja_ruta/' + this.hojaRuta.id + '/derivacion'),
            };
        },
        watch: {
            hojaRuta: {
                deep: true,
                handler() {
                    this.derivaciones.loadFromAPI('/api/hoja_ruta/' + this.hojaRuta.id + '/derivacion');
                }
            }
        }
    };
</script>

<style scoped>
    .selected-item {
        font-size: 1rem;
        pointer-events: all!important;
        cursor: pointer;
    }
</style>
