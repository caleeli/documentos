<script>
    export default {
        data: function() {
            return {
                templateRender: null
            };
        },
        props: {
            template: String,
            data: Object
        },
        render(h) {
            if (!this.templateRender) {
                return h('div', 'loading...');
            } else { // If there is a template, I'll show it
                return this.templateRender();
            }
        },
        watch: {
            // Every time the template prop changes, I recompile it to update the DOM
            template: {
                immediate: true, // makes the watcher fire on first render, too.
                handler() {
                    var template = !this.template ? '<div>hola mundo</div>' : this.template;
                    var res = Vue.compile(template);
                    this.templateRender = res.render;
                    // staticRenderFns belong into $options, 
                    // appearantly
                    this.$options.staticRenderFns = []

                    // clean the cache of static elements
                    // this is a cache with the results from the staticRenderFns
                    this._staticTrees = []

                    // Fill it with the new staticRenderFns
                    for (var i in res.staticRenderFns) {
                        //staticRenderFns.push(res.staticRenderFns[i]);
                        this.$options.staticRenderFns.push(res.staticRenderFns[i])
                    }
                }
            }
        },
        updated() {
            this.$emit('updated', this);
        }
    }
</script>
