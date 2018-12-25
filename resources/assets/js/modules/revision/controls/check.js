export default {
    data() {
        return {
            /**
             * Define el componente vuejs que se mostrara al seleccionar
             * un tipo de elemento seleccionado
             * @todo rename to controls
             */
            inspector: {
                check: {
                    component: null,
                    select(vue, config) {
                        const options = ['\u00A0', '✓', '✕', 'N/A'];
                        vue.listaActual = config.list;
                        let index = (options.indexOf(vue.config.label) + 1) % options.length;
                        vue.config.label = options[index];
                        vue.setControlLabel(vue.config.label);
                    },
                },
            },
        };
    },
    methods: {
        check() {
            this.createToken({type: 'check', label: '\u00A0'}, 'token-inline');
        },
    }
};
