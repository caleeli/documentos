<template>
  <div class="btn-group" role="group">
    <action v-for="(action, key) in actions"
            v-bind:key="key"
            v-bind:class="(actionClass?actionClass+' ':'')+(action.class?action.class:'')"
            @click="handle(action, key)"
            v-bind:action="action"
            >
      {{action.name}}
    </action>
  </div>
</template>

<script>
  import Action from './Action.vue';

  export default {
      components: {
          Action
      },
      props: {
          actions: Object,
          actionClass: String,
          row: null
      },
      methods: {
          handle(action, key) {
              this.$emit(key, key, action, this.row);
              this.$emit('click', key, action, this.row);
          }
      }
  }
</script>
