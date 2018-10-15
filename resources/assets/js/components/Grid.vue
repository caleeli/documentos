<template>
  <table class="grid-table">
    <thead>
    <slot name="header" v-bind:data="value" v-bind:options="options"></slot>
    </thead>
    <tbody>
      <slot v-for="(row, i) in value" v-bind:row="row" v-bind:options="options" @click="click"></slot>
    </tbody>
  </table>
</template>

<script>
  export default {
      components: {
      },
      props: {
          value: Array,
          options: Object
      },
      data() {
          return {
          }
      },
      methods: {
          click(action, node, row) {
          }
      },
  }
</script>

<style lang="scss">
  .grid-table > tbody > tr > td:first-child {
      width: 0%;
  }
  .grid-table > tbody > tr > td:nth-child(2) {
      width: 0%;
  }
  .grid-table > tbody > tr > td:nth-child(3) {
      width: 100%;
  }
  .grid-open {

  }
  .grid-closed {
      display: none;
  }
</style>
