<template>
  <panel name="Informes" class="panel-primary">
    <grid-ajax
      v-model="data"
      filter-by="
              attributes.nombre_destinatario
              attributes.nombre_remitente
              attributes.referencia
              attributes.nro_informe
              "
    >
      <template slot="header">
        <th width="10%">Nro Informe</th>
        <th width="10%">Fecha Entrega</th>
        <th width="20%">Nombre destinatario</th>
        <th width="20%">Nombre remitente</th>
        <th width="20%">Referencia</th>
        <th width="20%">Gestión</th>
        <th></th>
      </template>
      <tr slot-scope="{row, options, format}">
        <td v-html="format(row.attributes.nro_informe)"></td>
        <td>
          <datetime type="date" v-model="row.attributes.fecha_entrega" read-only empty-date></datetime>
        </td>
        <td v-html="format(row.attributes.nombre_destinatario)"></td>
        <td v-html="format(row.attributes.nombre_remitente)"></td>
        <td v-html="format(row.attributes.referencia)"></td>
        <td v-html="format(row.attributes.gestion)"></td>
        <td>
          <router-link class="btn btn-primary" :to="{path: openPath(row.id)}">Abrir</router-link>
        </td>
      </tr>
    </grid-ajax>
  </panel>
</template>

<script>
const apiBase = {
  notas: "/api/notas_oficio",
  comunicacion: "/api/comunicaciones_internas",
  informes: "/api/informe"
};
const page = {
  notas: "/NotaOficio/",
  comunicacion: "/ComunicacionesInternas/",
  informes: "/Informe/"
};
export default {
  props: {
    type: String
  },
  data() {
    return {
      data: new ApiArray(apiBase[this.type] + "?sort=-nro_inf_id&per_page=200")
    };
  },
  watch: {
    type() {
      this.data.loadFromAPI(
        apiBase[this.type] + "?sort=-nro_inf_id&per_page=200"
      );
    }
  },
  methods: {
    openPath(id) {
      return page[this.type] + id;
    }
  },
  mounted() {
    this.data.loadFromAPI();
  }
};
</script>
