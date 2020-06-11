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
    valueField: null,
    title: String,
    type: {
      type: String,
      default: 'horizontalBar'
    },
    stacked: {
      type: Boolean,
      default: false,
    },
    colors: {
      type: Array,
      default() {
        return ['beige', 'salmon', 'lightblue', 'lightgreen'];
      },
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
      this.chartData = {
          labels: [],
          datasets: [{
              data: [],
          }],
      };
      this.chartData.labels.splice(0);
      this.data.forEach(row => {
        this.chartData.labels.push(row[this.labelField]);
      });
      const valueField = (this.valueField instanceof Array) ? this.valueField : [this.valueField];
      this.chartData.datasets.splice(0);
      valueField.forEach((field, index) => {
        const data = [];
        this.chartData.datasets.push({ backgroundColor: this.colors[index], data });
        this.data.forEach(row => {
          data.push(Number(row[field]));
        });
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
              },
              scales: {
                xAxes: [{
                  stacked: this.stacked,
                }],
                yAxes: [{
                  stacked: this.stacked,
                }]
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