<template>
<div>
  <div class="row">
    <div class="col" v-if="filterBy">
      <div class="btn-group input-group">
        <input type="text" class="form-control" style="height: 31px;" v-model="search">
        <button class="btn btn-outline-primary">
          <i class="fas fa-search"></i> Buscar
        </button>
      </div>
    </div>
    <div class="col">
      <div class="btn-group float-right">
        <button class="btn btn-outline-secondary">
          <i class="fas fa-long-arrow-alt-left"></i> Previo
        </button>
        <button class="btn btn-outline-secondary">
          Siguiente <i class="fas fa-long-arrow-alt-right"></i> 
        </button>
      </div>
    </div>
  </div>
  <table class="grid-table table">
    <thead>
    <slot name="header" v-bind:data="value" v-bind:options="options"></slot>
    </thead>
    <tbody>
      <slot v-for="row in currentPage" v-bind:row="row" v-bind:options="options" v-bind:format="format" @click="click"></slot>
    </tbody>
  </table>
  </div>
</template>

<script>
export default {
    props: {
        value: Array,
        filterBy: "",
        options: Object
    },
    computed: {
        currentPage() {
            let filters = this.filterBy ? this.filterBy.split(/[, ]+/) : [];
            let page = this.value.filterBy(filters, this.search);
            return page.slice(0, 10);
        }
    },
    data() {
        return {
            search: ""
        };
    },
    methods: {
        textValue(value) {
            return value;$("<i></i>")
                .text(value)
                .html();
        },
        format(input) {
            let value = String(input);
            if (!this.search) {
                return value;
            }
            let text = this.search;
            let length = text.length;
            let res = "";
            let u = -1;
            let i;
            while (
                (i = value
                    .toLowerCase()
                    .localeIndexOf(text, "en", { sensitivity: "base" })) > -1
            ) {
                res += value.substr(0, i);
                res += "<u>";
                res += value.substr(i, length);
                res += "</u>";
                u = i + length;
                value = value.substr(u);
            }
            res += value;
            return res;
        },
        click(action, node, row) {}
    }
};
</script>

<style lang="scss">
.grid-table {
    display: block;
    overflow: auto;
}
</style>
