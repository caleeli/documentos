<template>
  <panel name="ENTIDADES" class="panel-primary">
    <div class="container" v-if="entidad.attributes">
      <div class="row">
        <div class="col-12">
          <h4>Registro entidad:</h4>
        </div>
      </div>
      <error v-model="erroresentidad" property="message"></error>
      <div class="form-group row">
        <div :class="colLabel">
          <label>Clasificador (*):</label>
        </div>
        <div :class="colField">
          <input class="form-control" type="number" v-model="entidad.attributes.ent_clasificador" />
          <error v-model="erroresentidad" property="errors.ent_clasificador"></error>
        </div>
      </div>
      <div class="form-group row">
        <div :class="colLabel">
          <label>Sigla (*):</label>
        </div>
        <div :class="colField">
          <input class="form-control" type="text" v-model="entidad.attributes.ent_sigla" />
          <error v-model="erroresentidad" property="errors.ent_sigla"></error>
        </div>
      </div>
      <div class="form-group row">
        <div :class="colLabel">
          <label>Descripción (*):</label>
        </div>
        <div :class="colField">
          <input class="form-control" type="text" v-model="entidad.attributes.ent_descripcion" />
          <error v-model="erroresentidad" property="errors.ent_descripcion"></error>
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
  path: "/Entidad/:id",
  methods: {
    getUrlBase() {
      return "/api/entidad";
    },
    save() {
      if (this.entidad.id) {
        this.entidad
          .putToAPI(this.getUrlBase() + "/" + this.entidad.id)
          .then(response => {
            this.$router.go(-1);
          });
      } else {
        this.entidad.postToAPI(this.getUrlBase()).then(response => {
          this.$router.go(-1);
        });
      }
    },
    getIdURL() {
      //return isNaN(this.$route.params.id) ? 'create?factory=' + this.$route.params.type + '&include=userAdd,userMod' : this.$route.params.id + '?include=userAdd,userMod';
      return isNaN(this.$route.params.id)
        ? "create?"
        : this.$route.params.id + "";
    }
  },
  data() {
    const erroresentidad = {};
    return {
      entidad: new ApiObject(
        this.getUrlBase() + "/" + this.getIdURL(),
        erroresentidad
      ).loadFromAPI(),
      erroresentidad: erroresentidad
    };
  },
  watch: {
    "$route.params.id"() {
      this.entidad.loadFromAPI(this.getUrlBase() + "/" + this.getIdURL());
    }
  },
  mounted() {
    this.entidad.loadFromAPI();
  }
};
</script>

<style lang="scss">
.anexos tr td {
}
.anexos tr td small {
}
.selected-item {
  font-size: 1rem;
  pointer-events: all !important;
  cursor: pointer;
}
.selected-item:hover {
  text-decoration: underline;
}
</style>
