<template>
  <div class="panel" v-bind:class="{'panel-vertical': !isHorizontal(), 'panel-horizontal': isHorizontal(), 'panel-collapsed': collapsed}"
       style="display: grid; grid-template-rows: 4em calc(100% - 4em);">
    <!-- div v-bind:class="{card: 1, 'h-100': !collapsed}" -->
    <div class="card-header panel-heading clearfix">
      <span class="panel-title">
        <i v-bind:class="icon" v-if="icon"></i> {{name}}
      </span>
      <div class="panel-buttons panel-tool-options">
        <slot name="actions"></slot>
        <actions v-bind:actions="actions" v-bind:action-class="actionClass" @click="click" @collapse="collapse"></actions>
      </div>
    </div>
    <div class="card-body panel-body" v-show="!collapsed" style="overflow: auto">
        <div>
            <slot></slot>
        </div>
    </div>
  </div>
</template>

<script>
  export default {
      props: {
          icon: String,
          name: String,
          actions: Object,
          actionClass: String,
          direction: String
      },
      data() {
          return {
              collapsed: this.actions && this.actions.collapse ? this.actions.collapse.active : false,
          }
      },
      methods: {
          isHorizontal() {
              return this.direction !== 'vertical';
          },
          collapse(key, action) {
              this.collapsed = action.active;
          },
          click(key, action) {
              this.$emit(key, action);
              this.$emit('click', key, action);
          }
      }
  }
</script>

<style lang="scss" scoped>
  .panel-vertical {
      height: 100%;
  }
  .panel-vertical.panel-collapsed {
      width: 5em;
      height: 100%;
  }
  .panel-vertical.panel-collapsed .card-header {
      position: relative;
      /*display: inline-block;*/
      height: 100%;
  }
  .panel-vertical.panel-collapsed .panel-title {
      transform: rotate(-90deg) translate(0, 50%);
      transform-origin: 0 50%;
      position: absolute;
      white-space: pre;
      bottom: 0em;
  }
  .panel-vertical .panel-buttons {
      float: right;
  }
  .panel-vertical.panel-collapsed .panel-buttons {
      float: none;
  }

  .panel-horizontal {
      height: 100%;
  }
  .panel-horizontal .panel-buttons {
      float: right;
  }
  .panel-horizontal.panel-collapsed {
      height: auto;
  }
</style>
