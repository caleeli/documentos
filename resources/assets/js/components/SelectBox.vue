<template>
  <div>
    <input  class="form-control dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"
            @focus="focus" @blur="blur" @click="click"
            v-model="text">
    <ul class="dropdown-menu">
      <li v-for="(row, index) in dataFiltered" v-bind:value="row.id" v-if="index<5" class="dropdown-item">
      <slot :row="row" :format="format"></slot>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
      props: {
          placeholder: String,
          data: Array,
          value: null,
          filterBy: String
      },
      data() {
          return {
              localValue: null,
              text: '',
              dataFiltered: []
          }
      },
      watch: {
          data() {
              this.filter();
          },
          text() {
              this.filter();
          }
      },
      methods: {
          textValue(value) {
              return $('<i></i>').text(value).html();
          },
          format(input) {
              let value = this.textValue(input);
              if (!this.text) {
                  return value;
              }
              let text = this.text;
              let length = text.length;
              let res = '';
              let u = -1;
              let i;
              while ((i = value.toLowerCase().localeIndexOf(text, 'en', {sensitivity: 'base'})) > -1) {
                  res += value.substr(0, i - u - 1);
                  res += '<u>';
                  res += value.substr(i, length);
                  res += '</u>';
                  u = i + length;
                  value = value.substr(u);
              }
              res += value;
              return res;
          },
          filter() {
              const filters = this.filterBy ? this.filterBy.split(',') : [];
              const dataFiltered = this.data.filter(row => {
                  if (!this.text) {
                      return true;
                  }
                  for (let i = 0, l = filters.length; i < l; i++) {
                      if (this.find(row, filters[i].split('.'), this.text)) {
                          return true;
                      }
                  }
                  return false;
              });
              this.dataFiltered.splice(0);
              for (let i = 0, l = dataFiltered.length; i < l; i++) {
                  this.dataFiltered.push(dataFiltered[i]);
              }
          },
          find(row, filter, value) {
              if (filter.length === 0) {
                  return this.textValue(row).localeIndexOf(value, 'en', {sensitivity: 'base'}) > -1;
              }
              const att = filter.shift();
              if (att === '*' && row instanceof Array) {
                  for (let i = 0, l = row.length; i < l; i++) {
                      if (this.find(row[i], filter, value)) {
                          return true;
                      }

                  }
              } else if (att === '*') {
                  for (let a in row) {
                      if (this.find(row[a], filter, value)) {
                          return true;
                      }
                  }
              } else {
                  return this.find(row[att], filter, value);
              }
              return false;
          },
          isOpen() {
              return $(this.$el).find("ul:first").hasClass('show');
          },
          click() {
              $(this.$el).find(".dropdown-toggle").dropdown("toggle");
          },
          focus() {
              if (!this.isOpen()) {
                  $(this.$el).find(".dropdown-toggle").dropdown("toggle");
              }
          },
          blur() {
              if (this.isOpen()) {
                  $(this.$el).find(".dropdown-toggle").dropdown("toggle");
              }
          },
          change() {
              this.data.filter
          }
      },
      mounted() {
      }
  }
</script>

<style lang="scss" scoped>
  .select-box {
      position: relative;
  }
  .select-box input {
      border: none;
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0px;
      left: 12px;
  }
</style>
