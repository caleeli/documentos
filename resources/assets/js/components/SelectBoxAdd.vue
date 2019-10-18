<template>
  <div class="d-flex">
    <select-box class="flex-grow-1" :value="value" @input="input" v-bind="$props">
      <template slot-scope="{row,format,remove}">
        <slot :row="row" :format="format" :remove="remove"></slot>
      </template>
    </select-box>
    <button type="button" class="btn btn-primary" @click="addAction">
      <i :class="addIcon"></i>
    </button>
  </div>
</template>

<script>
export default {
  props: {
    placeholder: String,
    data: Array,
    value: null,
    filterBy: String,
    idField: {
      type: String,
      default: "id"
    },
    multiple: {
      type: Boolean,
      default: false
    },
    readonly: {
      type: Boolean,
      default: false
    },
    addIcon: {
      type: String,
      default: "fas fa-plus-square"
    }
  },
  methods: {
    input(value) {
      this.$emit("input", value);
    },
    addAction() {
      this.$emit("add");
    }
  }
};
</script>
