<template>
<div>
  <div class="row" v-if="!withoutNavbar">
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
        <button class="btn btn-outline-secondary" :disabled="page<1" @click="page=Math.max(0,page-1)">
          <i class="fas fa-long-arrow-alt-left"></i> Previo
        </button>
        <button class="btn btn-outline-secondary" :disabled="page>=lastPage" @click="page=Math.min(lastPage,page+1)">
          Siguiente <i class="fas fa-long-arrow-alt-right"></i> 
        </button>
      </div>
    </div>
  </div>
  <table class="grid-table table table-hover">
    <caption><loading v-if="value && value.loading"></loading></caption>
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
const PAGE_SIZE = 7;
export default {
    props: {
        value: Array,
        filter: String,
        filterBy: "",
        pageSize: Number,
        options: Object,
        withoutNavbar: Boolean,
    },
    computed: {
        lastPage () {
            const pageSize = this.pageSize ? this.pageSize : PAGE_SIZE;
            return Math.ceil(this.filteredValue.length / pageSize) - 1;
        },
        filteredValue () {
            const filters = this.filterBy ? this.filterBy.split(/[, ]+/) : [];
            return this.value.filterBy(filters, this.search);
        },
        currentPage () {
            const filters = this.filterBy ? this.filterBy.split(/[, ]+/) : [];
            const page = this.filteredValue;
            const pageSize = this.pageSize ? this.pageSize : PAGE_SIZE;
            return page.slice(this.page * pageSize, (this.page + 1) * pageSize);
        }
    },
    watch: {
        filter () {
            this.search = this.filter;
        }
    },
    data() {
        return {
            search: this.filter,
            page: 0,
        };
    },
    methods: {
        textValue(value) {
            return $("<i></i>")
                .html(value)
                .text();
        },
        format(input) {
            let value = this.textValue(input);//String(input);
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
                res += "<code>";
                res += value.substr(i, length);
                res += "</code>";
                u = i + length;
                value = value.substr(u);
            }
            res += value;
            return res;
        }
    }
};
</script>

<style lang="scss">
.grid-table {
    display: block;
    overflow: auto;
}
</style>
