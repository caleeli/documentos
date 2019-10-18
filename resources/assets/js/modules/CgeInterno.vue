<template>
  <panel name="CGE Interno" class="panel-primary">
    <div class="container" v-if="cge_interno.attributes">
      <div class="row">
        <div class="col-12">
          <h4>Registro CGE Interno:</h4>
        </div>
      </div>
      <error v-model="errorescge_interno" property="message"></error>
      <div class="form-group row">
        <div :class="colLabel">
          <label>Descripción (*):</label>
        </div>
        <div :class="colField">
          <input class="form-control" type="text" v-model="cge_interno.attributes.cge_descripcion" />
          <error v-model="errorescge_interno" property="errors.cge_descripcion"></error>
        </div>
      </div>
      <div class="form-group row">
        <div :class="colLabel"></div>
        <div :class="colField">
          <button type="button" class="btn btn-primary" @click="save">Guardar</button>
        </div>
      </div>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/CgeInterno/:id",
  methods: {
    getUrlBase() {
      return "/api/cge_interno";
    },
    save() {
      if (this.cge_interno.id) {
        this.cge_interno
          .putToAPI(this.getUrlBase() + "/" + this.cge_interno.id)
          .then(response => {
            this.$router.go(-1);
          });
      } else {
        this.cge_interno.postToAPI(this.getUrlBase()).then(response => {
          this.$router.go(-1);
        });
      }
    },
    getIdURL() {
      return isNaN(this.$route.params.id)
        ? "create?"
        : this.$route.params.id + "";
    }
  },
  data() {
    const errorescge_interno = {};
    return {
      cge_interno: new ApiObject(
        this.getUrlBase() + "/" + this.getIdURL(),
        errorescge_interno
      ).loadFromAPI(),
      errorescge_interno: errorescge_interno
    };
  },
  watch: {
    "$route.params.id"() {
      this.cge_interno.loadFromAPI(this.getUrlBase() + "/" + this.getIdURL());
    }
  },
  mounted() {
    this.cge_interno.loadFromAPI();
  }
};
</script>
