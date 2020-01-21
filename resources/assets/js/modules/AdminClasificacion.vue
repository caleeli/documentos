<template>
  <panel name="Administración de Clasificadores" class="panel-primary">
    <grid-ajax
      v-model="data"
      class="w-100"
      filter-by="attributes.sigla
              attributes.nombre
              "
    >
      <template slot="toolbar">
        <router-link
          class="btn btn-outline-success"
          :to="{path: '/admin/clasificacion/0'}"
        >
          <i class="fa fa-plus"></i>
          <small class="hidden-xs hidden-sm ml-1">Clasificación</small>
        </router-link>
        &nbsp;
      </template>
      <template slot="header">
        <th width="30%">ID</th>
        <th width="30%">Nombre</th>
        <th width="30%">Sigla</th>
        <th width="10%"></th>
      </template>
      <tr slot-scope="{row, options, format}">
        <td v-html="format(row.id)"></td>
        <td v-html="format(row.attributes.nombre)"></td>
        <td v-html="format(row.attributes.sigla)"></td>
        <td>
          <router-link class="btn btn-primary" :to="{path: `/admin/clasificacion/${row.id}`}">
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
  path: "/admin/clasificacion",
  props: {},
  data() {
    return {
      data: new ApiArray("/api/hoja_ruta_clasificacion?sort=nombre,sigla&per_page=7"),
      user: new ApiObject("/api/hoja_ruta_clasificacion/0")
    };
  },
  methods: {
    eliminar(row) {
      if (confirm("¿Está seguro de eliminar el registro?")) {
        this.user.deleteToAPI(`/api/hoja_ruta_clasificacion/${row.id}`).then(() => {
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
