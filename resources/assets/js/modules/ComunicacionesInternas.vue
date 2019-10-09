<template>
    <panel v-if="data.attributes" name="Comunicación Interna/Informe" class="panel-primary">
        <div class="container">
            <div class="row">
                <div class="col-12"><h4>Comunicaciones Internas</h4> </div>
            </div>
            <error v-model="errores" property="message"></error>

            <div class="form-group row">
                <div :class="colLabel"><label>Nº Hoja de Ruta:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.hoja_de_ruta" />
                    <error v-model="errores" property="errors.hoja_de_ruta"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Fecha de emisión:</label></div>
                <div :class="colField">
                    <datetime type="date" v-model="data.attributes.fecha_emision" />
                    <error v-model="errores" property="errors.fecha_emision"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Nº NOTA CGE/SCSL:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.nro_nota" readonly placeholder="Se generará automaticamente al guardar" />
                    <error v-model="errores" property="errors.nro_nota"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Reiterativa:</label></div>
                <div :class="colField">
                    <select class="form-control" v-model="data.attributes.reiterativa"><option value="SI">SI</option> <option value="NO">NO</option></select>
                    <error v-model="errores" property="errors.reiterativa"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Fecha de entrega:</label></div>
                <div :class="colField">
                    <datetime type="date" v-model="data.attributes.fecha_entrega" />
                    <error v-model="errores" property="errors.fecha_entrega"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Gerencia/Subcontraloria:</label></div>
                <div :class="colField">
                    <suggest v-model="data.attributes.gerencia_subcontraloria"
                             :data="gerenciasSubcontraloria"
                             id-field="attributes.gerencia_subcontraloria"
                             filter-by="attributes.gerencia_subcontraloria">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.gerencia_subcontraloria)" style="font-size: 1rem"></span>
                        </template>
                    </suggest>
                    <error v-model="errores" property="errors.gerencia_subcontraloria"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Nombre y apellidos:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.nombre_apellidos" />
                    <error v-model="errores" property="errors.nombre_apellidos"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Cargo:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.cargo" />
                    <error v-model="errores" property="errors.cargo"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Referencia:</label></div>
                <div :class="colField">
                    <text-box v-model="data.attributes.referencia" :reference="referenciarNota">
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
                    <error v-model="errores" property="errors.referencia"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Días otorgados para respuesta:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.dias" />
                    <error v-model="errores" property="errors.dias"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Días de retraso:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.retraso" />
                    <error v-model="errores" property="errors.retraso"></error>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <br><hr>
                    <h4>Nota Recibida</h4>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Nº Hoja de Ruta:</label></div>
                <div :class="colField">
                    <select-box :data="hojasRuta" v-model="data.attributes.hoja_de_ruta_recepcion"
                        id-field="attributes.nro_de_control"
                        filter-by="attributes.nro_de_control,attributes.referencia">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.nro_de_control)" class="badge" style="font-size: 1rem"></span>
                            <span v-html="format(row.attributes.referencia)" style="font-size: 1rem"></span>
                        </template>
                    </select-box>
                    <error v-model="errores" property="errors.hoja_de_ruta_recepcion"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Fecha de recepción:</label></div>
                <div :class="colField">
                    <datetime type="date" v-model="data.attributes.fecha_recepcion" />
                    <error v-model="errores" property="errors.fecha_recepcion"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Nº Nota:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.nro_nota_recepcion" />
                    <error v-model="errores" property="errors.nro_nota_recepcion"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Remitente:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.remitente_recepcion" />
                    <error v-model="errores" property="errors.remitente_recepcion"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Asunto o Referencia:</label></div>
                <div :class="colField">
                    <text-box v-model="data.attributes.referencia_recepcion" :reference="referenciarNota">
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
                    <error v-model="errores" property="errors.referencia_recepcion"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Fojas/ Arch./ Anillados/ Legajos/ Otros:</label></div>
                <div :class="colField">
                    <anexos v-model="data.attributes.fojas_recepcion"></anexos>
                    <error v-model="errores" property="errors.fojas_recepcion"></error>
                </div>
            </div>

            <div class="form-group row">
                <div :class="colLabel"></div>
                <div :class="colField">
                    <button type="button" class="btn btn-primary" @click="saveHR">Guardar</button>
                </div>
            </div>
        </div>
    </panel>
</template>

<script>
    const apiBase = '/api/comunicaciones_internas';
    export default {
        path: "/ComunicacionesInternas/:id",
        methods: {
            referenciarNota(nota) {
                return nota.attributes.nro_nota + " " + nota.attributes.referencia;
            },
            saveHR() {
                if (this.data.id) {
                    this.data.putToAPI(apiBase + "/" + this.data.id).then((response) => {
                        this.$router.push({path: "/NotaOficioBusqueda/comunicacion"});
                    });
                } else {
                    this.data.postToAPI(apiBase).then((response) => {
                        this.$router.push({path: "/NotaOficioBusqueda/comunicacion"});
                    });
                }
            },
            getIdURL() {
                return isNaN(this.$route.params.id) ? 'create?factory=create' : this.$route.params.id;
            },
        },
        data() {
            const errores = {};
            return {
                data: new ApiObject(apiBase + '/' + this.getIdURL(), errores).loadFromAPI(),
                errores: errores,
                notas: new ApiArray('/api/notas_oficio?sort=-id&per_page=2000'),
                hojasRuta: new ApiArray('/api/hoja_ruta?fields=nro_de_control,referencia&per_page=1000'),
                gerenciasSubcontraloria: new ApiArray(apiBase + '?fields=gerencia_subcontraloria&filter[]=groupby,"gerencia_subcontraloria"&per_page=-1'),
            };
        },
        watch: {
            '$route.params.id'() {
                this.data.loadFromAPI(apiBase + '/' + this.getIdURL());
            }
        },
        mounted() {
            this.data.loadFromAPI();
        }
    };
</script>
