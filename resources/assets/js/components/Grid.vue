<template>
  <table class="grid-table">
    <thead>
      <tr v-if="header.length">
        <vnode v-for="(column, j) in header" v-bind:key="j"
           v-bind:tpl="column"
           v-bind:data="options"
           ></vnode>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(row, i) in data" v-if="checkVif(row)" v-bind:class="rowClass(row)">
        <vnode v-for="(column, j) in columns" v-bind:key="j"
           v-bind:tpl="column"
           v-bind:data="row"
           @click="click"
           ></vnode>
    </tr>
    </tbody>
  </table>
</template>

<script>
  export default {
      components: {
      },
      props: {
          data: Array,
          options: Object,
          textColumn: Number,
      },
      data() {
          return {
              columns: [],
              header: [],
              textColumnD: this.textColumn === undefined ? 1 : this.textColumn,
              vif: 'row.icon || row.name',
              vClass: '""',
              sClass: ''
          }
      },
      methods: {
          checkVif(row) {
              return eval(this.vif);
          },
          rowClass(row) {
              return this.sClass + ' ' + eval(this.vClass);
          },
          click(action, node, row) {
          }
      },
      created() {
          const columns = this.columns;
          const header = this.header;
          columns.splice(0);
          for (let node of this.$slots.default) {
              if (node.tag) {
                  this.vif = node.data && node.data.attrs.vif ? node.data.attrs.vif : this.vif;
                  this.vClass = node.data && node.data.attrs.$class ? node.data.attrs.$class : this.vClass;
                  this.sClass = node.data && node.data.staticClass ? node.data.staticClass : this.sClass;
                  node.children.forEach(function (node) {
                      if (node.tag) {
                          columns.push(node2string(node, 'td'));
                      }
                  });
                  break;
              }
          }
      ;
          if (this.$slots.header) {
              this.$slots.header.forEach(function (node) {
                  if (node.tag) {
                      header.push(node2string(node, 'th'));
                  }
              });
          }
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
