<template>
  <div>{{dateFormated}}</div>
</template>
<script>
  import moment from 'moment';

  export default {
      props: {
          value: String,
          format: String
      },
      data() {
          return {
              time: Date.now()
          }
      },
      computed: {
          dateFormated() {
              return moment(this.value).format(this.format ? this.format : "YYYY-MM-DD HH:mm:ss");
          }
      },
      created() {
          setInterval(() => {
              this.time = Date.now();
          }, 1000);
      }
  }
</script>