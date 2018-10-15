<template>
  <span class="jdd-avatar-circle">
    <i v-if="!src" class="fa fa-user"></i>
    <img v-if="src" v-bind:src="src" />
  </span>
</template>
<script>

  export default {
      props: {
          value: Object,
          field: String
      },
      data() {
          return {
              fieldName: this.field ? this.field : 'avatar',
              avatar: {url: ""}
          };
      },
      watch: {
          value: {
              handler() {
                  this.avatar = this.value && this.value.attributes && this.value.attributes[this.fieldName]
                          ? this.value.attributes[this.fieldName] : (this.value ? this.value : {url: ""});
              },
              deep: true
          }
      },
      computed: {
          src() {
              return this.avatar.url ? this.avatar.url : '';
          }
      },
      mounted() {
      }
  }
</script>
<style lang="scss">
  .jdd-avatar-circle {
      width: 1em;
      height: 1em;
      display: inline-block;
      border-radius: 50%;
      background: white;
  }
  .jdd-avatar-circle img{
      width: 100%;
      height: 100%;
  }
</style>
