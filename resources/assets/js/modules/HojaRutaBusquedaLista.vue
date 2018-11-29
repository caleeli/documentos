<template>
    <panel :name="type.toLocaleUpperCase()" class="panel-primary">
        <grid v-model="data"
              filter-by="attributes.numero
              attributes.gestion
              attributes.referencia
              attributes.procedencia
              attributes.usuario_destinatario.attributes.nombres
              attributes.usuario_destinatario.attributes.apellidos
              attributes.estado
              ">
            <template slot="header">
                <th width="10%">Nro HR&#x2011;SCEP</th>
                <th width="10%">Hoja de Ruta</th>
                <th width="5%">Gestión</th>
                <th width="20%">Referencia</th>
                <th width="20%">Procedencia</th>
                <th width="20%">Destinario Actual</th>
                <th width="5%">Fecha de derivación</th>
                <th width="5%">Estado de Conclusión</th>
                <th width="5%">Fecha de Conclusión</th>
                <th></th>
            </template>
            <tr slot-scope="{row, options, format}">
                <td v-html="format('SCEP&#x2011;' + row.attributes.numero)"></td>
                <td v-html="format(row.attributes.nro_de_control)"></td>
                <td v-html="format(row.attributes.gestion)"></td>
                <td v-html="format(row.attributes.referencia)"></td>
                <td v-html="format(row.attributes.procedencia)"></td>
                <td>
                    <div v-if="row.attributes.usuario_destinatario && row.attributes.usuario_destinatario.attributes.nombres==='ARCHIVO'">
                        <avatar v-if="row.attributes.usuario_archivo" v-model="row.attributes.usuario_archivo" field="fotografia" />
                        <span v-html="format(row.attributes.usuario_archivo ? (row.attributes.usuario_archivo.attributes.nombres + ' ' + row.attributes.usuario_archivo.attributes.apellidos) : '')"></span>
                    </div>
                    <template v-else-if="row.attributes.usuario_destinatario">
                        <avatar v-model="row.attributes.usuario_destinatario" field="fotografia" />
                        <span v-html="format(row.attributes.usuario_destinatario ? (row.attributes.usuario_destinatario.attributes.nombres + ' ' + row.attributes.usuario_destinatario.attributes.apellidos) : '')"></span>
                    </template>
                    <template v-else>
                        <i class="fas fa-user-secret" style="color: black"></i>
                        no asignado
                    </template>
                </td>
                <td><datetime type="date" v-model="row.attributes.fecha_derivacion" read-only /></td>
            <td v-html="format(row.attributes.estado)"></td>
            <td><datetime type="date" v-model="row.attributes.conclusion" read-only empty-date="no concluido" /></td>
            <td>
            <router-link class="btn btn-primary" :to="{path:'/HojaRuta/' + row.id}">Abrir</router-link>
            </td>
            </tr>
        </grid>
    </panel>
</template>

<script>
    export default {
        props: {
            type: String,
        },
        data() {
            return {
                data: new ApiArray('/api/hoja_rutas?sort=-id&filter[]=where,tipo,=,"' + this.type + '"&per_page=200')
            };
        },
        watch: {
            type() {
                this.data.loadFromAPI('/api/hoja_rutas?sort=-id&filter[]=where,tipo,=,"' + this.type + '"&per_page=200');
            }
        },
    };
</script>
