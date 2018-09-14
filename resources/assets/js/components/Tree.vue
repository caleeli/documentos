<template>
  <table class="tree-table">
    <thead>
      <tr v-if="header.length">
        <th v-bind:colspan="2"></th>
        <th v-for="(column, j) in header" v-bind:colspan="j == textColumnD ? (maxLevel - 1 + 1) : 1"><vnode 
        v-bind:tpl="column"
        v-bind:data="options"
        ></vnode></th>
    </tr>
    </thead>
    <tbody>
      <tr v-for="(row, i) in flatTree" v-if="checkVif(row)">
        <td v-bind:colspan="row.$level + 1"></td>
        <td v-for="(column, j) in columns" v-bind:colspan="j == textColumnD ? (maxLevel - row.$level + 1) : 1">
    <vnode 
        v-bind:class="{'tree-open': !flatTree[row.$parent].$collapsed, 'tree-closed': flatTree[row.$parent].$collapsed}"
        v-bind:tpl="column"
        v-bind:data="row"
        v-bind:parent="flatTree[row.$parent]"
        @collapse="collapse"
        @click="click"
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
          vif: String,
      },
      data() {
          return {
              maxLevel: 0,
              columns: [],
              flatTree: [],
              header: [],
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
          checkVif(row){
              return eval(this.vif ? this.vif : 'row.icon || row.name');
          },
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
          collapse(action, row, node) {
              node.data.$collapsed = action.active;
              this.flatTree.splice(0);
              this.flat(this.tree, 0, this.flatTree);
          },
          click(action, node, row){
            console.log(action, node, row);
          }
      },
      created() {
          const columns = this.columns;
          const header = this.header;
          columns.splice(0);
          this.$slots.default.forEach(function (node) {
              if (node.tag) {
                  columns.push(node2string(node));
              }
          });
          if (this.$slots.header) {
              this.$slots.header.forEach(function (node) {
                  if (node.tag) {
                      header.push(node2string(node));
                  }
              });
          }
          this.flatTree.splice(0);
          this.maxLevel = 0;
          this.flat(this.tree, 0, this.flatTree);
      }
  }
</script>

<style lang="scss">
  .tree-table > tbody > tr > td:first-child {
      width: 0%;
  }
  .tree-table > tbody > tr > td:nth-child(2) {
      width: 0%;
  }
  .tree-table > tbody > tr > td:nth-child(3) {
      width: 100%;
  }
  .tree-open {

  }
  .tree-closed {
      display: none;
  }
</style>
