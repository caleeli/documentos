<template>
  <div class="input-group mb-3">
    <input
      v-model="local"
      type="number"
      class="form-control"
      :readonly="!editable"
      min="0"
      max="99999"
      placeholder="0"
    />
    <div class="input-group-append" v-if="editable">
      <a
        href="javascript:void(0)"
        class="input-group-text bg-primary text-white"
        @click="local=Math.max(0, local*1-1)"
      >
        <i class="fas fa-minus"></i>
      </a>
    </div>
    <div class="input-group-append" v-if="editable">
      <a
        href="javascript:void(0)"
        class="input-group-text bg-primary text-white"
        @click="local=Math.min(99999, local*1+1)"
      >
        <i class="fas fa-plus"></i>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: null,
    editable: Boolean
  },
  watch: {
    local(local) {
      local != this.value ? this.$emit("input", local) : null;
    },
    value(value) {
      value != this.local ? (this.local = value) : null;
    }
  },
  data() {
    return {
      local: this.value
    };
  }
};
</script>
