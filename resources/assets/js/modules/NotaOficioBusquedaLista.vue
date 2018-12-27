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
                <th width="10%">Hoja de Ruta</th>
                <th width="10%">Fecha Emision</th>
                <th width="5%">Nro Nota</th>
                <th width="20%">Reiterativa</th>
                <th width="20%">Fecha Entrega</th>
                <th width="20%">Entidad/Empresa</th>
                <th width="5%">Nombre</th>
                <th width="5%">Cargo</th>
                <th width="5%">Días</th>
                <th></th>
            </template>
            <tr slot-scope="{row, options, format}">
                <td v-html="format(row.attributes.hoja_de_ruta)"></td>
                <td><datetime type="date" v-model="row.attributes.fecha_emision" read-only empty-date="" ></datetime></td>
                <td v-html="format(row.attributes.nro_nota)"></td>
                <td v-html="format(row.attributes.reiterativa)"></td>
                <td><datetime type="date" v-model="row.attributes.fecha_entrega" read-only empty-date="no salió" ></datetime></td>
                <td v-html="format(row.attributes.entidad_empresa)"></td>
                <td v-html="format(row.attributes.nombre_apellidos)"></td>
                <td v-html="format(row.attributes.cargo)"></td>
                <td v-html="format(row.attributes.dias)"></td>
            <td><router-link class="btn btn-primary" :to="{path: openPath(row.id)}">Abrir</router-link></td>
            </tr>
        </grid>
    </panel>
</template>

<script>
    const apiBase = {
        notas: '/api/notas_oficio',
        comunicacion: '/api/comunicaciones_internas',
    };
    const page = {
        notas: '/NotaOficio/',
        comunicacion: '/ComunicacionesInternas/',
    };
    export default {
        props: {
            type: String,
        },
        data() {
            return {
                data: new ApiArray(apiBase[this.type] + '?sort=-id&per_page=200')
            };
        },
        watch: {
            type() {
                this.data.loadFromAPI(apiBase[this.type] + '?sort=-id&per_page=200');
            }
        },
        methods: {
            openPath(id) {
                return page[this.type] + id;
            },
        },
    };
</script>
