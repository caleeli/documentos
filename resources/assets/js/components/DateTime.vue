<template>
  <span v-bind:class="myClass">
    {{readOnly ? dateFormated : ''}}
    <span v-if="!readOnly && type!='time'" class="input-group-addon form-control calendar-button">
      <i class="fa fa-calendar"></i>
      <input v-if="!readOnly" type="hidden" class="form-control">
    </span>
    <span v-if="!readOnly && type!='date'" class="clock-button">
      <input type="hidden" value="09:30">
      <span class="input-group-addon form-control" style="height: 100%; display: inline-block;">
        <span class="fa fa-clock"></span>
      </span>
    </span>
    <input type="text" class="form-control" v-bind:value="dateFormated">
  </span>
</template>
<script>
  import moment from 'moment';
  import datepicker from 'bootstrap-datepicker';
  import clockpicker from 'clockpicker/dist/bootstrap-clockpicker.min.js';

  export default {
      props: {
          value: String,
          format: String,
          type: String, //date,time,datetime
          readOnly: Boolean
      },
      data() {
          return {
              time: Date.now()
          }
      },
      computed: {
          dateFormated() {
              return moment(this.value).format(this.getDateFormat());
          },
          myClass() {
              return this.readOnly ? '' : 'input-group date';
          }
      },
      created() {
          setInterval(() => {
              this.time = Date.now();
          }, 1000);
      },
      mounted: function() {
          var self = this;
          if (self.value) {
              var date = moment(self.value);
              $(this.$el).find('.calendar-button input').val(date.format('YYYY-MM-DD'));
              $(this.$el).find('.clock-button input').val(date.format('HH:SS'));
          } else {
              $(this.$el).find('.calendar-button input').val('');
              $(this.$el).find('.clock-button input').val('');
          }
          this.$nextTick(() => {
              $(this.$el).find('.calendar-button').datepicker({
                  format: 'yyyy-mm-dd'
              }).on('changeDate', (e) => {
                  const time = self.getTime();
                  e.date.setHours(time.hour);
                  e.date.setMinutes(time.minute);
                  self.$emit('input', moment(e.date).format());
              });
              $(this.$el).find('.clock-button').clockpicker({
                  autoclose: true,
                  afterDone: () => {
                      const time = self.getTime();
                      const date = self.value ? moment(self.value) : moment();
                      date.set(time);
                      self.$emit('input', moment(date).format());
                  }
              });
          });
      },
      methods: {
          getTime() {
              const t = $(this.$el).find('.clock-button input')[0].value.split(':');
              const now = new Date();
              return t.length === 2 ? {hour: t[0] * 1, minute: t[0] * 1} : {hour: now.getHours(), minute: now.getMinutes()};
          },
          getDateFormat() {
              return this.format ? this.format : (this.type === 'date' ? "DD.MM.YYYY" : (this.type === 'time' ? "HH:mm" : "DD.MM.YYYY HH:mm"));
          },
          getBootstrapDateFormat() {
              let df = this.getDateFormat();
              df = df.split('YYYY').join('yyyy');
              df = df.split('MM').join('mm');
              df = df.split('DD').join('dd');
              return df;
          }
      }
  }
</script>
<style src='bootstrap-datepicker/dist/css/bootstrap-datepicker.css'>
  /* global styles */
</style> 
<style src='clockpicker/dist/bootstrap-clockpicker.css'>
  /* global styles */
</style> 
<style>
  .input-group-addon {
      background-color: #fff;
      border: 1px solid #E5E6E7;
      border-radius: 1px;
      color: inherit;
      font-weight: 400;
      line-height: 1;
      padding: 9px 12px 4px 12px;
      text-align: center;
      max-width: 3em;
  }
</style>
