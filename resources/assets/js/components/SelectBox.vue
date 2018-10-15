<template>
  <select v-model="localValue">
    <option v-for="row in data" v-bind:value="row.id"><vnode fromSlot="default" v-bind:data="row"></vnode></option>
  </select>
</template>

<script>
  export default {
      props: {
          placeholder: String,
          data: Array,
          value: null
      },
      data() {
          return {
              localValue: null
          }
      },
      methods: {
      },
      mounted() {
      }
  }
</script>

<style lang="scss" scoped>
</style>
