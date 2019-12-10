<template>
    <panel v-if="data.attributes" :name="data.attributes.numero ? 'HOJA DE RUTA - N° SCSL - ' + data.attributes.numero : 'HOJA DE RUTA - N° SCSL' " class="panel-primary">
           <template slot="actions">
            <span v-if="data.attributes.created_at">
                <i class="fas fa-user-plus"></i>
                <label v-if="data.relationships.userAdd">{{data.relationships.userAdd.attributes.nombre_completo}}</label>
                {{moment(data.attributes.created_at + '+00:00').fromNow()}}
            </span>
            <span v-if="data.attributes.updated_at">
                <i class="fas fa-user-edit"></i>
                <label v-if="data.relationships.userMod">{{data.relationships.userMod.attributes.nombre_completo}}</label>
                {{moment(data.attributes.updated_at + '+00:00').fromNow()}}
            </span>
        </template>
        <div class="container">
            <div class="row">
                <div class="col-12"><h4>Registro de Correspondencia: {{data.attributes.tipo}}</h4> </div>
            </div>
            <error v-model="erroresHojaRuta" property="message"></error>
            <div class="form-group row">
                <div :class="colLabel"><label>Procedencia (*):</label></div>
                <div :class="colField">
                    <template v-for="(procedencia, index) in tipoProcedencia">
                        <div class="row" :key="index">
                            <div class="radio col-6">
                                <label>
                                    <input :disabled="!pendiente" type="radio" name="tipo_procedencia"
                                           :value="procedencia.codigo"
                                           v-model="data.attributes.tipo_procedencia"
                                           >
                                    {{procedencia.descripcion}}
                                </label>
                            </div>
                        </div>
                    </template>
                    <error v-model="erroresHojaRuta" property="errors.tipo_procedencia"></error>
                </div>
            </div>
            <div v-if="data.attributes.tipo_procedencia==='entidad'" class="form-group row">
                <div :class="colLabel"><label>Entidad (*):</label></div>
                <div :class="colField">
                    <select-box-add :readonly="!pendiente" :data="entidades" v-model="data.attributes.procedencia"
                        id-field="attributes.ent_descripcion"
                        filter-by="attributes.ent_clasificador,attributes.ent_descripcion,attributes.ent_sigla"
                        @add="showEntidad">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.ent_clasificador)" class="badge" style="font-size: 1rem"></span>
                            <span v-html="format(row.attributes.ent_descripcion)" style="font-size: 1rem"></span>
                            <span v-html="format(row.attributes.ent_sigla)" style="font-size: 1rem"></span>
                        </template>
                    </select-box-add>
                    <error v-model="erroresHojaRuta" property="errors.procedencia"></error>
                </div>
            </div>
            <div v-if="data.attributes.tipo_procedencia==='natural' || data.attributes.tipo_procedencia==='juridica'" class="form-group row">
                <div :class="colLabel"><label>Nombres y Apellidos (*):</label></div>
                <div :class="colField">
                    <select-box-add :readonly="!pendiente" :data="personas" v-model="data.attributes.procedencia"
                        id-field="attributes.nombre_completo"
                        filter-by="attributes.per_nombres,attributes.per_apellidos,attributes.per_ci_nit"
                        add-icon="fas fa-user-plus"
                        @add="showPersona">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.per_nombres)" class="badge" style="font-size: 1rem"></span>
                            <span v-html="format(row.attributes.per_apellidos)" style="font-size: 1rem"></span>
                            <span v-html="format(row.attributes.per_ci_nit)" style="font-size: 1rem"></span>
                        </template>
                    </select-box-add>
                    <error v-model="erroresHojaRuta" property="errors.procedencia"></error>
                </div>
            </div>          
            <div v-if="data.attributes.tipo_procedencia==='interno'" class="form-group row">
                <div :class="colLabel"><label>CGE Interno (*):</label></div>
                <div :class="colField">
                    <select-box-add :readonly="!pendiente" :data="cgeInternos" v-model="data.attributes.procedencia"
                        id-field="attributes.cge_descripcion"
                        filter-by="attributes.cge_descripcion"
                        @add="showCgeInterno">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.cge_descripcion)" style="font-size: 1rem"></span>
                        </template>
                    </select-box-add>
                    <error v-model="erroresHojaRuta" property="errors.procedencia"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Fecha de recepción (*):</label></div>
                <div :class="colField">
                    <datetime :read-only="!pendiente" type="date" v-model="data.attributes.fecha_recepcion" />
                    <error v-model="erroresHojaRuta" property="errors.fecha_recepcion"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Referencia (*):</label></div>
                <div :class="colField">
                    <text-box :readonly="!pendiente" v-model="data.attributes.referencia" tags="#@&" :reference="referenciar" :referenceUrl="urlReferencia">
                        <template slot="dropdown" slot-scope="{code,select,tag}">
                            <grid-ajax v-if="tag==='#'" v-model="notas" :filter="code" :without-navbar="true"
                                       filter-by="id
                                       attributes.referencia">
                                <tr slot-scope="{row, options, format}" @click="select(row)">
                                    <td v-html="format(row.id)" style="white-space: pre;"></td>
                                    <td v-html="format(row.attributes.referencia)"></td>
                                </tr>
                            </grid-ajax>
                            <grid-ajax v-if="tag==='@'" v-model="informes" :filter="code" :without-navbar="true"
                                       filter-by="id
                                       attributes.referencia">
                                <tr slot-scope="{row, options, format}" @click="select(row)">
                                    <td v-html="format(row.id)" style="white-space: pre;"></td>
                                    <td v-html="format(row.attributes.referencia)"></td>
                                </tr>
                            </grid-ajax>
                            <grid-ajax v-if="tag==='&'" v-model="comunicaciones" :filter="code" :without-navbar="true"
                                       filter-by="id
                                       attributes.referencia">
                                <tr slot-scope="{row, options, format}" @click="select(row)">
                                    <td v-html="format(row.id)" style="white-space: pre;"></td>
                                    <td v-html="format(row.attributes.referencia)"></td>
                                </tr>
                            </grid-ajax>
                        </template>
                    </text-box>
                    <error v-model="erroresHojaRuta" property="errors.referencia"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Destinatario (*):</label></div>
                <div :class="colField">
                    <suggest :readonly="!pendiente" :data="destinatarios" v-model="data.attributes.destinatario" :multiple="true"
                        id-field="attributes.nombre_completo"
                        filter-by="attributes.nombre_completo">
                        <template slot-scope="{row,format,remove}">
                            <!-- Used to render the selected items -->
                            <template v-if="remove">
                                <span class="selected-item badge badge-light mr-1" v-html="format(row.attributes.nombre_completo)" @click="remove(row)"></span>
                            </template>
                            <!-- Used to render the items in the selection list -->
                            <template v-else>
                                <span v-html="format(row.attributes.nombre_completo)" style="font-size: 1rem"></span>
                            </template>
                        </template>
                    </suggest>
                    <error v-model="erroresHojaRuta" property="errors.destinatario"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>N° de control (*):</label></div>
                <div :class="colField">
                    <input :readonly="!pendiente" class="form-control" type="text" v-model="data.attributes.nro_de_control" />
                    <error v-model="erroresHojaRuta" property="errors.nro_de_control"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Anexo Hojas:</label></div>
                <div :class="colField">
                    <anexos v-model="data.attributes.anexo_hojas" :pendiente="pendiente"></anexos>
                    <error v-model="erroresHojaRuta" property="errors.anexo_hojas"></error>
                </div>
            </div>

            <div class="form-group row">
                <div :class="colLabel"><label>Tipo de Hoja de Ruta (*):</label></div>
                <div :class="colField">
                    <template v-for="tipo in tipoHr">
                        <div class="row">
                            <div class="radio col-6">
                                <label>
                                    <input type="radio" name="tipo_hr"
                                           :value="tipo.codigo"
                                           v-model="data.attributes.tipo_hr"
                                           :disabled="data.id || !pendiente">
                                    {{tipo.descripcion}}
                                </label>
                            </div>
                        </div>
                    </template>
                    <error v-model="erroresHojaRuta" property="errors.tipo_hr"></error>
                </div>
            </div>

            <div class="form-group row">
                <div :class="colLabel"><label>Clasificación (*):</label></div>
                <div :class="colField">
                    <template v-for="clasificacion in clasificacionHojasRuta">
                        <div class="row">
                            <div class="radio col-6">
                                <label>
                                    <input type="radio" name="hoja_edit_tipo"
                                           :disabled="!pendiente" 
                                           :value="clasificacion.attributes.sigla"
                                           v-model="data.attributes.tipo_tarea">
                                    {{clasificacion.attributes.nombre}}
                                </label>
                            </div>
                            <div class="col-6"
                                 v-show="data.attributes.tipo_tarea===clasificacion.attributes.sigla"
                                 v-if="clasificacion.relationships.subclases && clasificacion.relationships.subclases.length">
                                <select :disabled="!pendiente" class="form-control input-sm" v-model="data.attributes.subtipo_tarea">
                                    <option value=""></option>
                                    <option v-for="subclase in clasificacion.relationships.subclases"
                                        :key="subclase.id"
                                        :value="subclase.id">{{subclase.attributes.nombre}}</option>
                                </select>
                            </div>
                        </div>
                    </template>
                    <error v-model="erroresHojaRuta" property="errors.tipo_tarea"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"></div>
                <div :class="colField">
                    <button type="button" class="btn btn-primary" @click="saveHR">{{getGuardarLabel}}</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <derivaciones v-if="data.id" :hoja-ruta="data" :type="$route.params.type"></derivaciones>
                </div>
            </div>
        </div>
    </panel>
</template>

<script>
    export default {
        //path: "/HojaRuta/:type/:id",
        path: "/HojaRuta/:id",
        computed: {
            pendiente() {
                return !this.data.attributes.fecha_conclusion;
            },
            getGuardarLabel(){
                if (this.data.id) {
                    return 'Guardar Cambios';
                } else {
                    return 'Guardar';
                }
            },
            getFjs() {
                return this.getAnexo("fjs");
            },
            getArch() {
                return this.getAnexo("arch");
            },
            getAnillados() {
                return this.getAnexo("anillados");
            },
            getLegajo() {
                return this.getAnexo("legajo");
            },
            getEjemplar() {
                return this.getAnexo("ejemplar");
            },
            getEngrapado() {
                return this.getAnexo("engrapado");
            },
            getCd() {
                return this.getAnexo("cd");
            },
        },
        methods: {
            getUrlBase() {
                return "/api/hoja_ruta";
            },
            urlReferencia(tag, id) {
                return tag === "#" ? `#/NotaOficio/${id}` : (tag === "@" ? `#/Informe/${id}` : (tag === "&" ? `/ComunicacionesInternas/${id}` : ""));
            },
            referenciar(reference) {
                return reference.id + " (" + String(reference.attributes.referencia).trim() + ")";
            },
            saveHR() {
                this.clasificacionHojasRuta.forEach(clasificacion => {
                    if (clasificacion.attributes.sigla === this.data.attributes.tipo_tarea) {
                        let subclase = clasificacion.relationships.subclases.find(subclase => subclase.id === this.data.attributes.subtipo_tarea);
                        this.data.attributes.subtipo_tarea = subclase ? subclase.id : null;
                    }
                });

                if (this.data.id) {
                    this.data.putToAPI(this.getUrlBase() + "/" + this.data.id).then((response) => {
                        //this.$router.push({params: {id: response.data.data.id}});
                        this.$router.push({path: '/HojaRutaBusqueda', query:this.$route.query});
                    });
                } else {
                    this.data.callMethod('getNumeroSecuencia',{'tipo' : this.data.attributes.tipo_hr})
                        .then(response => {
                            this.data.attributes.numero = response.data.response;
                            this.data.postToAPI(this.getUrlBase()).then((response) => {
                                //this.$router.push({params: {id: response.data.data.id}});
                                this.$router.push({path: '/HojaRutaBusqueda'});
                            });
                    });
                }

            },
            getIdURL() {
                //return isNaN(this.$route.params.id) ? 'create?factory=' + this.$route.params.type + '&include=userAdd,userMod' : this.$route.params.id + '?include=userAdd,userMod';
                return isNaN(this.$route.params.id) ? 'create?factory=create&include=userAdd,userMod' : this.$route.params.id + '?include=userAdd,userMod';
            },
            setFjs(event) {
                this.setAnexo('fjs', event.target.value);
            },
            setArch(event) {
                this.setAnexo('arch', event.target.value);
            },
            setAnillados(event) {
                this.setAnexo('anillados', event.target.value);
            },
            setLegajo(event) {
                this.setAnexo('legajo', event.target.value);
            },
            setEjemplar(event) {
                this.setAnexo('ejemplar', event.target.value);
            },
            setEngrapado(event) {
                this.setAnexo('engrapado', event.target.value);
            },
            setCd(event) {
                this.setAnexo('cd', event.target.value);
            },
            getAnexo(index) {
                return this.anexoHojas[index];
            },
            setAnexo(anexoA, value) {
                this.anexoHojas[anexoA] = value;
                this.$set(this.data.attributes,'anexo_hojas',this.anexoToString());
            },
            getNumero(tipo) {
                this.data.callMethod('getNumeroSecuencia',{'tipo' : tipo})
                    .then(response => {
                       return response.data.response;
                    });
            },
            showCgeInterno() {
                this.$router.push({path: '/CgeInterno/create', query:this.$route.query});
            },
            showEntidad() {
                this.$router.push({path: '/Entidad/create', query:this.$route.query});
            },
            showPersona() {
                this.$router.push({path: '/Persona/create', query:this.$route.query});
            },
            anexoToString() {
                let res = '';
                for (const [key, value] of Object.entries(this.anexoHojas)) {
                    res += value + ' ' + key + ', ';
                }
                if (res != ''){
                    res = res.slice(0, -2);
                }
                return res;
            },
            initAnexos(){
                this.anexoHojas["fjs"] = null;
                this.anexoHojas["arch"] = null;
                this.anexoHojas["anillados"] = null;
                this.anexoHojas["legajo"] = null;
                this.anexoHojas["ejemplar"] = null;
                this.anexoHojas["engrapado"] = null;
                this.anexoHojas["cd"] = null;
            },
            cargarAnexos() {
                if (this.data.id) {
                    let aux = (this.data.attributes.anexo_hojas || '').split(", ");
                    for (const [key, value] of Object.entries(aux)) {
                        let anexo = value.split(" ");
                        this.anexoHojas[anexo[1]] = anexo[0];
                    }
                }
            },
            cargaInicial(){
                this.cargarAnexos();
                if (this.data.id) {
                    this.data.attributes.tipo_procedencia = 'entidad';
                }
            }
        },
        data() {
            const erroresHojaRuta = {};
            return {
                data: new ApiObject(this.getUrlBase() + '/' + this.getIdURL(), erroresHojaRuta).loadFromAPI(),
                erroresHojaRuta: erroresHojaRuta,
                procedencias: new ApiArray('/api/empresas?per_page=1000'),
                entidades: new ApiArray('/api/entidad?per_page=1000').loadFromAPI(),
                personas: new ApiArray('/api/persona?per_page=1000').loadFromAPI(),
                cgeInternos: new ApiArray('/api/cge_interno?per_page=1000').loadFromAPI(),
                destinatarios: new ApiArray('/api/users?filter[]=whereNoReservado&filter[]=where,role_id,1&per_page=1000'),
                notas: new ApiArray('/api/notas_oficio?per_page=7'),
                comunicaciones: new ApiArray('/api/comunicaciones_internas?per_page=7'),
                informes: new ApiArray('/api/informe?per_page=7'),
                clasificacionHojasRuta: new ApiArray('/api/hoja_ruta_clasificacion?include=subclases&sort=id'),
                tipoProcedencia: [  {codigo: 'entidad', descripcion: 'Entidad'}, 
                                    {codigo: 'natural', descripcion: 'Persona Natural'}, 
                                    {codigo: 'juridica', descripcion: 'Persona Jurídica'},
                                    {codigo: 'interno', descripcion: 'CGE Interno'},
                                ],
                tipoHr: [   {codigo: 'externa', descripcion: 'Celestes'}, 
                            {codigo: 'interna', descripcion: 'Rosadas'}, 
                            {codigo: 'solicitud', descripcion: 'Amarillas'}
                                ],
                anexoHojas: []
                //mostrarPersona: false,
            };
        },
        mounted() {
            this.cargaInicial();
            this.data.loadFromAPI();
        },
        watch: {
            '$route.params.id'() {
                this.data.loadFromAPI(this.getUrlBase() + '/' + this.getIdURL());
            },
            '$route.params.type'() {
                this.data.loadFromAPI(this.getUrlBase() + '/' + this.getIdURL());
            }
        }
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
