<template>
  <panel name="Administración de Usuarios" class="panel-primary">
    <grid-ajax
      v-model="data"
      class="w-100"
      filter-by="attributes.username
              attributes.nombres
              attributes.apellidos
              "
    >
      <template slot="toolbar">
        <router-link
          class="btn btn-outline-success"
          :to="{path: '/admin/usuarios/0'}"
        >
          <i class="fa fa-plus"></i>
          <small class="hidden-xs hidden-sm ml-1">Usuario</small>
        </router-link>
        &nbsp;
      </template>
      <template slot="header">
        <th width="25%">Usuario</th>
        <th width="25%">Nombre</th>
        <th width="25%">Apellido</th>
        <th width="10%">Rol</th>
        <th width="15%"></th>
      </template>
      <tr slot-scope="{row, options, format}">
        <td v-html="format(row.attributes.username)"></td>
        <td v-html="format(row.attributes.nombres)"></td>
        <td v-html="format(row.attributes.apellidos)"></td>
        <td v-html="format(row.attributes.role_id)"></td>
        <td>
          <router-link class="btn btn-primary" :to="{path: `/admin/usuarios/${row.id}`}">
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
  path: "/admin/usuarios",
  props: {},
  data() {
    return {
      data: new ApiArray("/api/users?sort=nombres,apellidos&per_page=7"),
      user: new ApiObject("/api/users/0")
    };
  },
  methods: {
    eliminar(row) {
      if (confirm("¿Está seguro de eliminar el registro?")) {
        this.user.deleteToAPI(`/api/users/${row.id}`).then(() => {
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
