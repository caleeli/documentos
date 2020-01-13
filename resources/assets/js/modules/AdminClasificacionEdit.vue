<template>
  <panel name="Administración de Clasificador N1" class="panel-primary">
    <template slot="actions">
      <a href="javascript:history.go(-1)" class="btn btn-sm btn-light">
        <i class="fas fa-arrow-left"></i>
      </a>
    </template>
    <form v-if="data.attributes">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input
          v-model="data.attributes.nombre"
          type="text"
          class="form-control"
          id="nombre"
          aria-describedby="nombre"
          placeholder="Nombre"
        />
        <error v-model="errores" property="nombre"></error>
      </div>
      <div class="form-group">
        <label for="sigla">Sigla</label>
        <input
          v-model="data.attributes.sigla"
          type="text"
          class="form-control"
          id="sigla"
          aria-describedby="sigla"
          placeholder="Sigla"
        />
        <error v-model="errores" property="sigla"></error>
      </div>
      <button type="button" class="btn btn-primary" @click="save">
        <i class="fa fa-save"></i> Guardar
      </button>
    </form>
  </panel>
</template>

<script>
export default {
  path: "/admin/clasificacion/:id",
  props: {},
  data() {
    const errores = {};
    return {
      errores,
      data: new ApiObject(
        `/api/hoja_ruta_clasificacion/${this.$route.params.id}`,
        errores
      )
    };
  },
  methods: {
    save() {
      if (this.$route.params.id) {
        this.data
          .putToAPI(`/api/hoja_ruta_clasificacion/${this.$route.params.id}`)
          .then(() => {
            window.history.go(-1);
          });
      } else {
        this.data.postToAPI(`/api/hoja_ruta_clasificacion`).then(() => {
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
