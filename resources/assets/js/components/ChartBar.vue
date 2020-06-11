<template>
  <div style="width:30em;">
    <canvas ref="chart" v-if="display" :height="height"></canvas>
  </div>
</template>

<script>
export default {
  props: {
    data: Array,
    labelField: String,
    valueField: String,
    title: String,
    type: {
      type: String,
      default: 'horizontalBar'
    },
  },
  data() {
    return {
      display: true,
      chart: null,
      chartData: {
          labels: [],
          datasets: [{
              data: [],
          }],
      },
    };
  },
  computed: {
    height() {
      return this.type === 'horizontalBar' ? 20 * this.data.length : 200;
    },
  },
  methods: {
    prepareData() {
      this.chartData.labels.splice(0);
      this.data.forEach(row => {
        this.chartData.labels.push(row[this.labelField]);
      });
      this.chartData.datasets[0].data.splice(0);
      this.data.forEach(row => {
        this.chartData.datasets[0].data.push(Number(row[this.valueField]));
      });
    },
    buildChart() {
      this.prepareData();
      const ctx = this.$refs.chart.getContext('2d');
      this.chart = new Chart(ctx, {
          type: this.type,
          data: this.chartData,
          options: {
              legend: {
                  display: false
              },
              elements: {
                  rectangle: {
                      borderWidth: 2,
                  }
              },
              responsive: true,
              title: {
                  display: true,
                  text: this.title
              }
          }
      });
    },
    drawChart() {
      this.display = false;
      this.$nextTick(() => {
        this.display = true;
        this.$nextTick(() => {
          this.buildChart();
        });
      });
    },
  },
  watch: {
    data() {
      //this.prepareData();
      //this.chart.update();
      this.drawChart();
    },
  },
  mounted() {
    this.drawChart();
  },
}
</script>

<style>

</style>