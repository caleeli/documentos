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
                <div :class="colLabel"><label>Fecha de recepción:</label></div>
                <div :class="colField">
                    <datetime type="date" v-model="data.attributes.fecha_recepcion" />
                    <error v-model="erroresHojaRuta" property="errors.fecha_recepcion"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Procedencia:</label></div>
                <div :class="colField">
                    <template v-for="(procedencia, index) in tipoProcedencia">
                        <div class="row">
                            <div class="radio col-6">
                                <label>
                                    <input type="radio" name="tipo_procedencia"
                                           :value="procedencia.codigo"
                                           v-model="tipoProcedenciaCheck"
                                           >
                                    {{procedencia.descripcion}}
                                </label>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div v-if="tipoProcedenciaCheck==='ENT'" class="form-group row">
                <div :class="colLabel"><label>Entidad:</label></div>
                <div :class="colField">
                    <select-box :data="entidades" v-model="data.attributes.procedencia"
                        id-field="attributes.ent_descripcion"
                        filter-by="attributes.ent_clasificador,attributes.ent_descripcion,attributes.ent_sigla">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.ent_clasificador)" class="badge" style="font-size: 1rem"></span>
                            <span v-html="format(row.attributes.ent_descripcion)" style="font-size: 1rem"></span>
                            <span v-html="format(row.attributes.ent_sigla)" style="font-size: 1rem"></span>
                        </template>
                    </select-box>
                    <error v-model="erroresHojaRuta" property="errors.entidades"></error>
                </div>
            </div>
            <div v-if="tipoProcedenciaCheck!=='ENT'" class="form-group row">
                <div :class="colLabel"><label>Nombres y Apellidos:</label></div>
                <div class="col-7">
                    <select-box :data="personas" v-model="data.attributes.procedencia"
                        id-field="attributes.nombre_completo"
                        filter-by="attributes.per_nombres,attributes.per_apellidos,attributes.per_ci_nit">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.per_nombres)" class="badge" style="font-size: 1rem"></span>
                            <span v-html="format(row.attributes.per_apellidos)" style="font-size: 1rem"></span>
                            <span v-html="format(row.attributes.per_ci_nit)" style="font-size: 1rem"></span>
                        </template>
                    </select-box>
                    <error v-model="erroresHojaRuta" property="errors.persona"></error>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-primary" @click="showPersona"><i class="fas fa-user-plus"></i></button>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Referencia:</label></div>
                <div :class="colField">
                    <text-box v-model="data.attributes.referencia" tags="#@&" :reference="referenciar" :referenceUrl="urlReferencia">
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
                    <error v-model="erroresHojaRuta" property="errors.destinatario"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>N° de control:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.nro_de_control" />
                    <error v-model="erroresHojaRuta" property="errors.nro_de_control"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Anexo Hojas:</label></div>
                <div :class="colField">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 pr-0">
                            <table class="anexos">
                                <tr>
                                    <td>
                                        <input class="form-control text-center" type="number" :value="getFjs" @input="setFjs">
                                        <small class="form-text text-muted">fjs</small>
                                    </td>
                                    <td>
                                        <input class="form-control text-center" type="number" :value="getArch" @input="setArch">
                                        <small class="form-text text-muted">arch</small>
                                    </td>
                                    <td>
                                        <input class="form-control text-center" type="number" :value="getAnillados" @input="setAnillados">
                                        <small class="form-text text-muted">anillados</small>
                                    </td>
                                    <td>
                                        <input class="form-control text-center" type="number" :value="getLegajo" @input="setLegajo">
                                        <small class="form-text text-muted">legajo</small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-6 col-xs-10 pl-sm-0">
                            <table class="anexos">
                                <tr>
                                    <td>
                                        <input class="form-control text-center" type="number" :value="getEjemplar" @input="setEjemplar">
                                        <small class="form-text text-muted">ejemplar</small>
                                    </td>
                                    <td>
                                        <input class="form-control text-center" type="number" :value="getEngrapado" @input="setEngrapado">
                                        <small class="form-text text-muted">engrapado</small>
                                    </td>
                                    <td>
                                        <input class="form-control text-center" type="number" :value="getCd" @input="setCd">
                                        <small class="form-text text-muted">cd</small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <error v-model="erroresHojaRuta" property="errors.anexo_hojas"></error>
                </div>
            </div>

            <div class="form-group row">
                <div :class="colLabel"><label>Tipo de Hoja de Ruta:</label></div>
                <div :class="colField">
                    <template v-for="(tipo, index) in tipoHr">
                        <div class="row">
                            <div class="radio col-6">
                                <label>
                                    <input type="radio" name="tipo_hr"
                                           :value="tipo.codigo"
                                           v-model="data.attributes.tipo_hr">
                                    {{tipo.descripcion}}
                                </label>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="form-group row">
                <div :class="colLabel"><label>Clasificación:</label></div>
                <div :class="colField">
                    <template v-for="clasificacion in clasificacionHojasRuta">
                        <div class="row">
                            <div class="radio col-6">
                                <label>
                                    <input type="radio" name="hoja_edit_tipo"
                                           :value="clasificacion.attributes.sigla"
                                           v-model="data.attributes.tipo_tarea">
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
                    </template>
                    <error v-model="erroresHojaRuta" property="errors.tipo_tarea"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"></div>
                <div :class="colField">
                    <button type="button" class="btn btn-primary" @click="saveHR">Guardar</button>
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
                        this.$router.push({params: {id: response.data.data.id}});
                    });
                } else {
                    this.data.callMethod('getNumeroSecuencia',{'tipo' : this.data.attributes.tipo_hr})
                        .then(response => {
                            this.data.attributes.numero = response.data.response;
                            this.data.postToAPI(this.getUrlBase()).then((response) => {
                                this.$router.push({params: {id: response.data.data.id}});
                            });
                    });
                }

            },
            getIdURL() {
                //return isNaN(this.$route.params.id) ? 'create?factory=' + this.$route.params.type + '&include=userAdd,userMod' : this.$route.params.id + '?include=userAdd,userMod';
                return isNaN(this.$route.params.id) ? 'create?&include=userAdd,userMod' : this.$route.params.id + '?include=userAdd,userMod';
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
                let regexp = new RegExp("(\\d+)\\s+" + index);
                let ma = this.data.attributes.anexo_hojas ? this.data.attributes.anexo_hojas.match(regexp) : null;
                return ma ? ma[1] : "";
            },
            setAnexo(anexoA, value) {
                const anexoHojas = [];
                const tipos = [
                    'fjs',
                    'arch',
                    'anillados',
                    'legajo',
                    'ejemplar',
                    'engrapad',
                    'cd',
                ];
                for (let index of tipos) {
                    let anexo = index == anexoA ? value : this.getAnexo(index);
                    if (anexo) {
                        anexoHojas.push(anexo + ' ' + index);
                    }
                }
                this.data.attributes.anexo_hojas = anexoHojas.join(', ');
            },
            getNumero(tipo) {
                this.data.callMethod('getNumeroSecuencia',{'tipo' : tipo})
                    .then(response => {
                       //return this.$set(this.data.attributes, 'numero', response.data.response);
                       return response.data.response;
                    });
            },
            showPersona() {
                this.$router.push({path: '/Persona/create', query:this.$route.query});
            }
        },
        data() {
            const erroresHojaRuta = {};
            return {
                data: new ApiObject(this.getUrlBase() + '/' + this.getIdURL(), erroresHojaRuta).loadFromAPI(),
                erroresHojaRuta: erroresHojaRuta,
                procedencias: new ApiArray('/api/empresas'),
                entidades: new ApiArray('/api/entidad'),
                personas: new ApiArray('/api/persona'),
                destinatarios: new ApiArray('/api/users'),
                notas: new ApiArray('/api/notas_oficio?sort=-id&per_page=7'),
                comunicaciones: new ApiArray('/api/comunicaciones_internas?sort=-id&per_page=7'),
                informes: new ApiArray('/api/informe?sort=-id&per_page=7'),
                clasificacionHojasRuta: new ApiArray('/api/hoja_ruta_clasificacion?include=subclases'),
                tipoProcedencia: [  {codigo: 'ENT', descripcion: 'Entidad'}, 
                                    {codigo: 'NAT', descripcion: 'Persona Natural'}, 
                                    {codigo: 'JUR', descripcion: 'Persona Jurídica'}
                                ],
                tipoProcedenciaCheck: 'ENT',
                tipoHr: [   {codigo: 'externa', descripcion: 'Externas'}, 
                            {codigo: 'interna', descripcion: 'Internas'}, 
                            {codigo: 'solicitud', descripcion: 'Solicitudes o Denuncias'}
                                ],
            };
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
