<template>
    <panel v-if="data.attributes" name="Notas Oficio" class="panel-primary">
        <div class="container">
            <div class="row">
                <div class="col-12"><h4>Informe</h4> </div>
            </div>
            <error v-model="errores" property="message"></error>

            <div class="form-group row">
                <div :class="colLabel"><label>Fecha entrega:</label></div>
                <div :class="colField">
                    <datetime type="date" v-model="data.attributes.fecha_entrega" />
                    <error v-model="errores" property="errors.fecha_entrega"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Nombre destinatario:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.nombre_destinatario" />
                    <error v-model="errores" property="errors.nombre_destinatario"></error>
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Nombre remitente:</label></div>
                <div :class="colField">
                    <input class="form-control" type="text" v-model="data.attributes.nombre_remitente" />
                    <error v-model="errores" property="errors.nombre_remitente"></error>
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
                <div :class="colLabel"><label>Hoja ruta:</label></div>
                <div :class="colField">
                    <select-box :data="hojasRuta" v-model="data.attributes.ref_hoja_ruta"
                        filter-by="attributes.referencia">
                        <template slot-scope="{row,format}">
                            <span v-html="format(row.attributes.referencia)" style="font-size: 1rem"></span>
                        </template>
                    </select-box>
                    <error v-model="errores" property="errors.ref_hoja_ruta"></error>
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
    const apiBase = '/api/informe';
    export default {
        path: "/Informe/:id",
        methods: {
            referenciarNota(nota) {
                return nota.attributes.nro_nota + " " + nota.attributes.referencia;
            },
            saveHR() {
                if (this.data.id) {
                    this.data.putToAPI(apiBase + "/" + this.data.id).then((response) => {
                        this.$router.push({params: {id: response.data.data.id}});
                    });
                } else {
                    this.data.postToAPI(apiBase).then((response) => {
                        this.$router.push({params: {id: response.data.data.id}});
                    });
                }
            },
            getIdURL() {
                return isNaN(this.$route.params.id) ? 'create' : this.$route.params.id;
            },
        },
        data() {
            const errores = {};
            return {
                data: new ApiObject(apiBase + '/' + this.getIdURL(), errores).loadFromAPI(),
                errores: errores,
                notas: new ApiArray('/api/notas_oficio?sort=-id&per_page=2000'),
                hojasRuta: new ApiArray('/api/hoja_ruta?sort=-id&per_page=2000'),
            };
        },
        watch: {
            '$route.params.id'() {
                this.data.loadFromAPI(apiBase + '/' + this.getIdURL());
            }
        }
    };
</script>
