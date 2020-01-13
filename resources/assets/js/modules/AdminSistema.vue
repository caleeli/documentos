<template>
  <panel name="Administración del Sistema" class="panel-primary">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-light">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <form v-if="data.attributes">
      <div class="form-group">
        <label for="name">Nombre del Sistema (Pestaña del Navegador)</label>
        <input
          v-model="data.attributes.name"
          type="text"
          class="form-control"
          id="name"
          aria-describedby="name"
          placeholder="Nombre del sistema"
        />
      </div>
      <div class="form-group">
        <label for="logo">Logo</label>
        <span class="btn btn-primary btn-block" style="position: relative;">
          Subir (alto mínimo recomendado 40px)
          <upload accept="image/*" v-model="data.attributes.logo" v-bind:multiplefile="false" />
        </span>
      </div>
      <button type="button" class="btn btn-primary" @click="save">
        <i class="fa fa-save"></i> Guardar
      </button>
    </form>
  </panel>
</template>

<script>
export default {
  path: "/admin/sistema",
  props: {},
  data() {
    const errores = {};
    return {
      errores,
      data: new ApiObject(`/api/system/config`, errores)
    };
  },
  methods: {
    save() {
      if (confirm("¿Está seguro de guardar los cambios?")) {
        this.data.postToAPI(`/api/system/config`).then(() => {
          window.location.reload();
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
