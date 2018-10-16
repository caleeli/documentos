<template>
  <component v-bind:is="type()" v-bind:to="action.href ? action.href : ''"
             v-bind:class="{ active: action.active===true}"
             @click="click">
    <i v-bind:class="action.active===true && action.iconActive ? action.iconActive : action.icon"
       v-if="action.icon"></i>
    <slot></slot>
  </component>
</template>

<script>
  export default {
      props: {
          action: Object
      },
      methods: {
          type() {
              return this.action.href ? 'router-link' : 'a';
          },
          click() {
              if (this.action.active !== undefined) {
                  this.action.active = !this.action.active;
              }
              this.$emit('click');
          }
      }
  }
</script>
