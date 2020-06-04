<template>
  <table class="table">
      <thead>
          <tr>
              <th v-for="col in columns" :key="`colh-${col.key}`" scope="col">{{ col.label }}</th>
          </tr>
      </thead>
      <tbody>
          <tr v-for="(row, index) in data" :key="`row-${index}`">
              <td v-for="col in columns" :key="`col-${index}-${col.key}`">{{ row[col.key] }}</td>
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
}
</script>

<style>

</style>