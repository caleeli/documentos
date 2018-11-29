<template>
    <div>
        <div class="container" v-if="derivacion.attributes">
            <div class="row">
                <div class="col-12"><h4>Derivaciones</h4> </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Fecha de derivación:</label></div>
                <div :class="colField"><datetime type="date" v-model="derivacion.attributes.fecha" /></div>
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
                </div>
            </div>
            <div class="form-group row">
                <div :class="colLabel"><label>Dias plazo:</label></div>
                <div :class="colField"><input class="form-control" type="number" v-model="derivacion.attributes.dias_plazo" /></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
        },
        methods: {
            referenciarNota(nota) {
                return nota.attributes.nro_nota + " " + nota.attributes.referencia;
            },
        },
        data() {
            return {
                notas: new ApiArray('/api/notas_oficio?sort=-id&per_page=5000'),
                destinatarios: new ApiArray('/api/users'),
                derivacion: new ApiObject('/api/derivacion/create'),
                instrucciones: new ApiArray('/api/instruccion'),
            };
        },
        watch: {
        }
    };
</script>

<style lang="scss">
</style>
