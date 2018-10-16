<template>
  <span v-bind:class="myClass">
    {{readOnly ? dateFormated : ''}}
    <a v-if="!readOnly && type!='time'" href="javascript:void(0)" class="calendar-button">
      <i class="fa fa-calendar"></i>
      <input v-if="!readOnly" type="hidden">
    </a>
    <span v-if="!readOnly && type!='date'" class="clock-button">
      <input type="hidden" value="09:30">
      <a class="input-group-addon" href="javascript:void(0)">
        <span class="fa fa-clock"></span>
      </a>
    </span>
    {{dateFormated}}
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
              return this.readOnly ? '' : 'form-control';
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
                  autoclose: true,
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
              return t.length === 2 ? {hour: t[0] * 1, minute: t[1] * 1} : {hour: now.getHours(), minute: now.getMinutes()};
          },
          getDateFormat() {
              return this.format ? this.format : (this.type === 'date' ? "DD.MM.YYYY" : (this.type === 'time' ? "HH:mm" : "DD.MM.YYYY HH:mm"));
          }
      }
  }
</script>
<style src='bootstrap-datepicker/dist/css/bootstrap-datepicker.css'></style> 
<style src='clockpicker/dist/bootstrap-clockpicker.css'></style> 
<style>
  .input-group-addon {
  }
</style>
