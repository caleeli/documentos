<template>
    <div>
        <div class="container" v-if="derivacion.attributes">
            <div class="row">
                <div class="col-12"><h4>Derivaciones</h4> </div>
            </div>
            <div class="invalid-feedback">
                {{erroresDerivacion}}
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Fecha de derivación:</label></div>
                <div :class="colField">
                    <datetime type="date" v-model="derivacion.attributes.fecha" />
                    <validation-error v-model="erroresDerivacion.fecha"></validation-error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Comentarios</label></div>
                <div :class="colField">
                    <text-box v-model="derivacion.attributes.comentarios" :reference="referenciarNota">
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
                    <validation-error v-model="erroresDerivacion.comentarios"></validation-error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Destinatario:</label></div>
                <div :class="colField">
                    <select-box :data="destinatarios" v-model="derivacion.attributes.destinatario"
                        filter-by="attributes.nombre_completo">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.nombre_completo)" style="font-size: 1rem"></span>
                        </template>
                    </select-box>
                    <validation-error v-model="erroresDerivacion.destinatario"></validation-error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Instrucción</label></div>
                <div :class="colField">
                    <select-box :data="instrucciones" v-model="derivacion.attributes.instruccion" id-field="attributes.sigla"
                        filter-by="attributes.sigla,attributes.nombre">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.nombre)" style="font-size: 1rem"></span>
                        </template>
                    </select-box>
                    <validation-error v-model="erroresDerivacion.instruccion"></validation-error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Dias plazo:</label></div>
                <div :class="colField">
                    <input class="form-control" type="number" v-model="derivacion.attributes.dias_plazo" />
                    <validation-error v-model="erroresDerivacion.dias_plazo"></validation-error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"></div>
                <div :class="colField">
                    <button type="button" class="btn btn-primary" @click="registrarDerivacion">Registrar</button>
                    <button type="button" class="btn btn-primary" @click="terminarHojaRuta">Terminar</button>
                </div>
            </div>
        </div>
        <grid v-model="derivaciones"
              filter-by="attributes.destinatario
              attributes.comentarios
              ">
            <template slot="header">
                <th width="10%">Fecha de derivación</th>
                <th width="30%">Destinatario</th>
                <th width="30%">Comentarios</th>
                <th width="20%">Instrucción</th>
                <th width="10%">Días plazo</th>
            </template>
            <tr slot-scope="{row, options, format}">
                <td><datetime v-model="row.attributes.fecha" :read-only="true" type="date"/></td>
            <td v-html="format(row.attributes.destinatario)"></td>
            <td v-html="format(row.attributes.comentarios)"></td>
            <td>{{row.attributes.instruccion}}</td>
            <td>{{row.attributes.dias_plazo}}</td>
            </tr>
        </grid>
    </div>
</template>

<script>
    export default {
        props: {
            hojaRuta: Object
        },
        computed: {
        },
        methods: {
            terminarHojaRuta() {

            },
            registrarDerivacion() {
                //this.derivacion.attributes.hoja_ruta_id = this.hojaRuta.id;
                this.derivacion.postToAPI('/api/hoja_ruta/' + this.hojaRuta.id + '/derivacion');
            },
            referenciarNota(nota) {
                return nota.attributes.nro_nota + " " + nota.attributes.referencia;
            },
        },
        data() {
            const erroresDerivacion = {};
            return {
                notas: new ApiArray('/api/notas_oficio?sort=-id&per_page=5000'),
                destinatarios: new ApiArray('/api/users'),
                derivacion: new ApiObject('/api/derivacion/create', erroresDerivacion),
                erroresDerivacion: erroresDerivacion,
                instrucciones: new ApiArray('/api/instruccion'),
                derivaciones: new ApiArray('/api/hoja_ruta/' + this.hojaRuta.id + '/derivacion'),
            };
        },
        watch: {
        }
    };
</script>

<style lang="scss">
</style>
