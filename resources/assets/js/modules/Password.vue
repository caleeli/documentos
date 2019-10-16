<template>
  <div>
    <panel name="Cambiar Contraseña" class="panel-primary">
      <div class="row">
        <div class="col-2">
          <div class="form-group">
            <label for="password">Contraseña</label>
          </div>
        </div>
        <div class="col-8">
          <div class="form-group">
            <input
              type="password"
              id="password"
              v-model="password"
              class="form-control"
              aria-describedby="passwordHelpInline"
            />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
          <div class="form-group">
            <label for="confirmar">Confirmar Contraseña</label>
          </div>
        </div>
        <div class="col-8">
          <div class="form-group">
            <input
              type="password"
              id="confirmar"
              v-model="confirmar"
              class="form-control"
              aria-describedby="passwordHelpInline"
            />
            <small
              v-if="password!=confirmar"
              class="badge badge-danger"
            >Debe conincidir con la contraseña.</small>
          </div>
        </div>
      </div>
      <button
        type="button"
        :disabled="password!=confirmar"
        class="btn btn-primary"
        @click="actualizar"
      >Actualizar</button>
    </panel>
  </div>
</template>

<script>
export default {
  path: "/cambiar_password",
  data() {
    return {
      password: "",
      confirmar: ""
    };
  },
  methods: {
    actualizar() {
      if (this.password === this.confirmar) {
        this.$root.user.attributes.password = this.password;
        this.$root.user.putToAPI('/api/user/' + this.$root.user.id);
      }
    }
  }
};
</script>
