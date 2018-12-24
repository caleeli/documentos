export default {
    data() {
        return {
            /**
             * Nombre de la lista activa
             */
            listaActual: '',
            /**
             * Define el componente vuejs que se mostrara al seleccionar
             * un tipo de elemento seleccionado
             * @todo rename to controls
             */
            inspector: {
                select: {
                    component: 'ControlGenerico',
                    select(vue, config) {
                        vue.listaActual = config.list;
                        vue.selectionListMenu = config.type === 'select' && !vue.selectionListMenu;
                    },
                    change(value, vue){
                        vue.selectionListMenu = false;
                        vue.setControlLabel(value);
                    },
                },
            },
        };
    },
    methods: {
        lista(config) {
            this.createToken(Object.assign(config, {type: 'select'}));
        },
        listaSetValue(value) {
            this.$set(this.data, this.config.name, value);
            this.control.change(value, this, this.config);
        },
    }
};
