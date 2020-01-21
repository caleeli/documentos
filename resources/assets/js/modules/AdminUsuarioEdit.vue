<template>
  <panel name="Administración de Usuarios" class="panel-primary">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-light">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <form v-if="data.attributes">
      <error v-model="errores" property="message"></error>
      <div class="form-group">
        <label for="username">Usuario</label>
        <input
          v-model="data.attributes.username"
          type="text"
          class="form-control"
          id="username"
          aria-describedby="username"
          placeholder="Nombre de usuario"
        />
        <error v-model="errores" property="username"></error>
      </div>
      <div class="form-group">
        <label for="nombres">Nombre(s)</label>
        <input
          v-model="data.attributes.nombres"
          type="text"
          class="form-control"
          id="nombres"
          aria-describedby="nombres"
          placeholder="Nombres"
        />
        <error v-model="errores" property="nombres"></error>
      </div>
      <div class="form-group">
        <label for="apellidos">Apellido(s)</label>
        <input
          v-model="data.attributes.apellidos"
          type="text"
          class="form-control"
          id="apellidos"
          aria-describedby="apellidos"
          placeholder="Apellidos"
        />
        <error v-model="errores" property="nombres"></error>
      </div>
      <div class="form-group">
        <label for="apellidos">Contraseña</label>
        <input
          v-model="data.attributes.password"
          type="password"
          class="form-control"
          id="password"
          aria-describedby="password"
          placeholder="********"
        />
        <error v-model="errores" property="password"></error>
      </div>
      <div class="form-group">
        <label for="apellidos">Número CI</label>
        <input
          v-model="data.attributes.numero_ci"
          type="text"
          class="form-control"
          id="numero_ci"
          aria-describedby="numero_ci"
          placeholder="numero ci"
        />
        <error v-model="errores" property="numero_ci"></error>
      </div>
      <div class="form-group">
        <label for="role_id">Rol</label>
        <select
          v-model="data.attributes.role_id"
          class="form-control"
          id="role_id"
          aria-describedby="apellidos"
          placeholder="Apellidos"
        >
          <option></option>
          <option value="1">1 (Admin)</option>
          <option value="2">2 (Registrador)</option>
          <option value="3">3 (Revisor)</option>
          <option value="4">4 (Revisor 2)</option>
        </select>
        <error v-model="errores" property="role_id"></error>
      </div>
      <button type="button" class="btn btn-primary" @click="save">
        <i class="fa fa-save"></i> Guardar
      </button>
    </form>
  </panel>
</template>

<script>
export default {
  path: "/admin/usuarios/:id",
  props: {},
  data() {
    const errores = {};
    return {
      errores,
      data: new ApiObject(`/api/users/${this.$route.params.id}`, errores)
    };
  },
  methods: {
    save() {
      if (parseInt(this.$route.params.id)) {
        this.data.putToAPI(`/api/users/${this.$route.params.id}`).then(() => {
          window.history.go(-1);
        });
      } else {
        this.data.postToAPI(`/api/users`).then(() => {
          window.history.go(-1);
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
</style>
