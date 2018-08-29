<template>
  <table class="grid-table">
    <tbody>
      <tr v-for="(row, i) in flatTree" v-if="row.icon || row.name">
        <td v-bind:colspan="row.$level + 1"></td>
        <td v-for="(column, j) in columns" v-bind:colspan="j == textColumnD ? (maxLevel - row.$level + 1) : 1">
          <vnode 
              v-bind:class="{'tree-open': !flatTree[row.$parent].$collapsed, 'tree-closed': flatTree[row.$parent].$collapsed}"
              v-bind:template="column"
              v-bind:data="row"
              v-bind:parent="flatTree[row.$parent]"
              @collapse="collapse"
              ></vnode>
        </td>
    </tr>
    </tbody>
  </table>
</template>

<script>
  export default {
      components: {
      },
      props: {
          options: Object,
          tree: Object,
          textColumn: Number,
      },
      data() {
          return {
              maxLevel: 0,
              columns: [],
              flatTree: [],
              textColumnD: this.textColumn === undefined ? 1 : this.textColumn
          }
      },
      watch: {
          tree: {
              handler(val) {
                  this.flatTree.splice(0);
                  this.flat(this.tree, 0, this.flatTree);
              },
              deep: true
          }
      },
      methods: {
          flat(tree, level = 0, flat = [], parent = 0) {
              let row = tree;
              let index = flat.length;
              Vue.set(row, '$level', level);
              Vue.set(row, '$parent', parent);
              if (row.$collapsed === undefined) {
                  Vue.set(row, '$collapsed', false);
              }
              this.maxLevel = Math.max(this.maxLevel, level);
              flat.push(row);
              if (tree.children) {
                  for (let i = 0, l = tree.children.length; i < l; i++) {
                      this.flat(tree.children[i], level + 1, flat, index);
                  }
              }
              return flat;
          },
          collapse(action, node) {
              node.data.$collapsed = action.active;
              this.flatTree.splice(0);
              this.flat(this.tree, 0, this.flatTree);
          }
      },
      created() {
          const columns = this.columns;
          columns.splice(0);
          this.$slots.default.forEach(function (node) {
              if (node.tag) {
                  columns.push(node2string(node));
              }
          });
          this.flatTree.splice(0);
          this.maxLevel = 0;
          this.flat(this.tree, 0, this.flatTree);
      }
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
