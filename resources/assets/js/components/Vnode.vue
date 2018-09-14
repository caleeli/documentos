<script>
  let vnodeTemplates = [];
  export default {
      vnodeName: 'vnodetpl',
      //template: '<vnodetpl v-bind:data="data" v-bind:row="data" v-bind:parent="parent"></vnodetpl>',
      render :function(createElement){
         return createElement(this.vnodeName,{
              attrs:{
                 'data':this.data,
                 'row':this.data,
                 'parent':this.parent
              }
           }
         )
      },
      props: {
          data: [Object, Array],
          parent: null,
          tpl: String,
          fromSlot: String
      },
      /**
       * Registra el componente que se encargara de dibujar el contenido
       */
      created() {
          const self = this;
          const template = this.tpl
                  ? this.tpl
                  : (this.$parent.$slots[this.fromSlot]
                          ? children2string(this.$parent.$slots[this.fromSlot]) : '<div></div>');
          let vnodeIndex = vnodeTemplates.indexOf(template);
          if (vnodeIndex === -1) {
              vnodeIndex = vnodeTemplates.length;
              vnodeTemplates.push(template);
          }
          this.vnodeName = 'vnodetpl' + vnodeIndex;
          let callbacks = {};
          for(let e in this._events) {
            callbacks[e] = (function (event) { return function (...args) {
                args.push(self);
                this.$parent.$emit.apply(this.$parent, args);
            }; })(e);
          }
          Vue.component(this.vnodeName, {
              name: this.vnodeName,
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
