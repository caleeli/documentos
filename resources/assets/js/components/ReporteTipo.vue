<template>
  <table class="table">
      <thead>
          <tr>
              <th v-for="col in columns" :key="`colh-${col.key}`" scope="col">{{ col.label }}</th>
          </tr>
      </thead>
      <tbody>
          <tr v-for="(row, index) in data" :key="`row-${index}`">
              <td v-for="col in columns" :key="`col-${index}-${col.key}`">
                <slot v-if="hasSlot(`col(${col.key})`)" :name="`col(${col.key})`" v-bind="{row, index}"></slot>
                <template v-else>
                  {{ row[col.key] }}
                </template>
              </td>
          </tr>
      </tbody>
      </table>
</template>

<script>
export default {
  props: {
    data: Array,
    columns: Array,
  },
  methods: {
    hasSlot(name) {
      return !!this.$scopedSlots[name];
    },
  },
}
</script>

<style>

</style>