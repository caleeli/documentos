<template>
  <panel name="Administración de Clasificadores N2" class="panel-primary">
    <grid-ajax
      v-model="data"
      class="w-100"
      filter-by="attributes.sigla
              attributes.sub_clase_id
              attributes.nombre
              relationships.clasificacion.attributes.nombre
              "
    >
      <template slot="toolbar">
        <router-link
          class="btn btn-outline-success"
          :to="{path: '/admin/subclasificacion/0'}"
        >
          <i class="fa fa-plus"></i>
          <small class="hidden-xs hidden-sm ml-1">Sub-Clasificación</small>
        </router-link>
        &nbsp;
      </template>
      <template slot="header">
        <th width="10%">ID</th>
        <th width="25%">Nombre</th>
        <th width="25%">Sigla</th>
        <th width="25%">Padre</th>
        <th width="15%"></th>
      </template>
      <tr slot-scope="{row, options, format}">
        <td v-html="format(row.id)"></td>
        <td v-html="format(row.attributes.nombre)"></td>
        <td v-html="format(row.attributes.sigla)"></td>
        <td v-html="format(row.relationships.clasificacion.attributes.nombre)"></td>
        <td>
          <router-link class="btn btn-primary" :to="{path: `/admin/subclasificacion/${row.id}`}">
            <i class="fa fa-pen"></i>
          </router-link>
          <a href="javascript:void(0)" class="btn btn-danger" @click="eliminar(row)">
            <i class="fa fa-times"></i>
          </a>
        </td>
      </tr>
    </grid-ajax>
  </panel>
</template>

<script>
export default {
  path: "/admin/subclasificacion",
  props: {},
  data() {
    return {
      data: new ApiArray("/api/hoja_ruta_sub_clases?sort=nombre,sigla&per_page=7&include=clasificacion"),
      user: new ApiObject("/api/hoja_ruta_sub_clases/0")
    };
  },
  methods: {
    eliminar(row) {
      if (confirm("¿Está seguro de eliminar el registro?")) {
        this.user.deleteToAPI(`/api/hoja_ruta_sub_clases/${row.id}`).then(() => {
          this.data.loadFromAPI();
        });
      }
    }
  },
  mounted() {
    this.data.loadFromAPI();
  }
};
</script>

<style>
.grid-table {
  display: table;
}
</style>
