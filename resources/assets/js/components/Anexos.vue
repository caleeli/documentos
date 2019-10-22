<template>
  <div class="d-flex flex-wrap">
    <div v-for="(val,key) in anexoHojas" :key="key" class="div-anexo mr-2">
      <input
        :readonly="!pendiente"
        class="form-control text-center"
        type="number"
        v-model="anexoHojas[key]"
      />
      <small class="form-text text-muted">{{key}}</small>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: String,
    pendiente: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      anexoHojas: {
        fjs: "",
        arch: "",
        anillados: "",
        legajo: "",
        ejemplar: "",
        engrapado: "",
        cd: "",
        folder: "",
        sobres: ""
      }
    };
  },
  watch: {
    anexoHojas: {
      deep: true,
      immediate: true,
      handler() {
        let res = [];
        for (const [key, value] of Object.entries(this.anexoHojas)) {
          res.push(value + " " + key);
        }
        const value = res.join(", ");
        value != this.value ? this.$emit("input", value) : null;
      }
    },
    value: {
      immediate: true,
      handler() {
        if (this.value) {
          let aux = (this.value || "").split(", ");
          for (const [key, value] of Object.entries(aux)) {
            let anexo = value.split(" ");
            this.anexoHojas[anexo[1]] = anexo[0];
          }
        }
      }
    }
  }
};
</script>

<style scoped>
.div-anexo {
  width: 6em;
}
</style>