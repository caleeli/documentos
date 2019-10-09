<template>
    <panel :name="'Busqueda'" class="panel-primary">
        <grid-ajax v-model="data"
              filter-by="attributes.numero
              attributes.gestion
              attributes.referencia
              attributes.procedencia
              ">
            <template slot="header">
                <th width="10%">Nro HR&#x2011;SCSL</th>
                <th width="10%">Nro Hoja de Ruta</th>
                <th width="10%">Nro Clasificación</th>
                <th width="5%">Gestión</th>
                <th width="5%">Tipo HR</th>
                <th width="20%">Referencia</th>
                <th width="20%">Procedencia</th>
                <th width="20%">Destinario Actual</th>
                <th width="5%">Fecha de derivación</th>
                <th width="5%">Estado</th>
                <th width="5%">Fecha de Conclusión</th>
                <th></th>
            </template>
            <tr slot-scope="{row, options, format}">
                <td v-html="format('SCSL&#x2011;' + row.attributes.numero)"></td>
                <td v-html="format(row.attributes.nro_de_control)"></td>
                <td v-html="format('SCSL&#x2011;' + row.attributes.tipo_tarea + '&#x2011;' + row.attributes.nro_de_control)"></td>
                <td v-html="format(row.attributes.gestion)"></td>
                <td v-html="format(row.attributes.tipo_hr_desc)"></td>
                <td v-html="format(row.attributes.referencia)"></td>
                <td v-html="format(row.attributes.procedencia)"></td>
                <td>
                    <div v-if="row.attributes.usuario_destinatario && row.attributes.usuario_destinatario.attributes.nombres==='ARCHIVO'">
                        <avatar v-if="row.attributes.usuario_archivo" v-model="row.attributes.usuario_archivo" field="fotografia" />
                        <span v-html="(row.attributes.usuario_archivo ? (row.attributes.usuario_archivo.attributes.nombres + ' ' + row.attributes.usuario_archivo.attributes.apellidos) : '')"></span>
                    </div>
                    <template v-else-if="row.attributes.usuario_destinatario">
                        <avatar v-model="row.attributes.usuario_destinatario" field="fotografia" />
                        <span v-html="(row.attributes.usuario_destinatario ? (row.attributes.usuario_destinatario.attributes.nombres + ' ' + row.attributes.usuario_destinatario.attributes.apellidos) : '')"></span>
                    </template>
                    <template v-else>
                        <i class="fas fa-user-secret" style="color: black"></i>
                        no asignado
                    </template>
                </td>
                <td><datetime type="date" v-model="row.attributes.fecha_derivacion" read-only /></td>
            <td v-html="(row.attributes.estado)"></td>
            <td><datetime type="date" v-model="row.attributes.fecha_conclusion" read-only empty-date="No Concluido" /></td>
            <td>
            <a class="btn btn-primary" :href="'/imprime_hr/' + row.id +'/1'" target="_blank"><i class="fa fa-print"></i></a>
            <a class="btn btn-primary" :href="'/imprime_hr/' + row.id +'/2'" target="_blank"><i class="fa fa-print"></i></a>
            <router-link class="btn btn-primary" :to="{path:'/HojaRuta/' + row.id}">Abrir</router-link>
            </td>
            </tr>
        </grid-ajax>
    </panel>
</template>

<script>
    export default {
        props: {
            //type: String,
        },
        data() {
            return {
                data: new ApiArray('/api/hoja_ruta?sort=-hr_id&per_page=7')
            };
        },
        /*watch: {
            type() {
                this.data.setSearchParams({'filter[]': 'where,tipo_hr,=,"' + this.type + '"'});
            }
        },*/
        mounted() {
            this.data.loadFromAPI();
        }
    };
</script>
