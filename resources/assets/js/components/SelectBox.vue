<template>
  <select>
    <option v-for="row in data" v-bind:value="row.id"><vnode fromSlot="default" v-bind:data="row"></vnode></option>
  </select>
</template>

<script>
  export default {
      props: {
          type: String,
          placeholder: String,
          api: String,
      },
      data() {
          return {
              data: []
          }
      },
      methods: {
      },
      mounted() {
          const self = this;
          $.ajax({
              url: this.api,
              dataType: 'json',
              success(data) {
                  for (let row of data.data) {
                      self.data.push(row);
                  }
              }
          });
      }
  }
</script>

<style lang="scss" scoped>
</style>
