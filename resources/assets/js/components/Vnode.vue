<script>
  export default {
      template: '<vnodetpl v-bind:data="data" v-bind:row="data" v-bind:parent="parent"/>',
      props: {
          data: [Object, Array],
          parent: null,
          template: String,
          fromSlot: String
      },
      /**
       * Registra el componente que se encargara de dibujar el contenido
       */
      created() {
          const self = this;
          const name = 'vnodetpl';
          const template = this.template
                  ? this.template
                  : (this.$parent.$slots[this.fromSlot]
                          ? children2string(this.$parent.$slots[this.fromSlot]) : '<div></div>');
          let callbacks = {};
          for(let e in this._events) {
            callbacks[e] = (function (event) { return function (...args) {
                args.push(self);
                this.$parent.$emit.apply(this.$parent, args);
            }; })(e);
          }
          Vue.component(name, {
              name: name,
              props: [
                  'data',
                  'row',
                  'parent',
              ],
              template: template,
              methods: callbacks
          });
      }
  }
</script>
