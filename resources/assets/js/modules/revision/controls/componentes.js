export default {
    data() {
        return {
            /**
             * DOM del control seleccionado
             */
            selected: null,
            /**
             * Configuracion del control seleccionado
             */
            config: {},
            /**
             * Se encargan de cargar los datos del elemento seleccionado
             */
            handlers: {
                parseConfig(base, element) {
                    const name = element.getAttribute('name');
                    try {
                        return Object.assign(base, name ? JSON.parse(name) : {});
                    } catch (e) {

                    }
                    return base;
                },
                SELECT(select) {
                    return this.parseConfig({}, select);
                },
            },
        };
    },
    computed: {
        control() {
            const control = this.inspector[this.config.type];
            return control ? control : {component: null, setLabel() {}};
        },
    },
    watch: {
        config: {
            deep: true,
            handler() {
                this.selected ? this.selected.setAttribute('name', JSON.stringify(this.config)) : null;
            }
        },
        selected(control) {
            const config = control ? this.handlers[control.nodeName](control) : {};
            this.$set(this, 'config', config);
        },
    },
    methods: {
        /**
         * Define el texto que se despliega en el control.
         *
         * @param {string} value
         */
        setControlLabel(value) {
            this.selected.firstChild.innerText = value;
        },
        /**
         * Crea un control dentro del documento
         *
         * @param {object} config
         */
        createToken(config, css = 'token') {
            const control = $('<select class="' + css + '" size="1" multiple><option>' + (config.label ? config.label : config.name) + '</option></select>');
            control.attr('name', JSON.stringify(config));
            const html = $('<div></div>').append(control).html();
            window.document.execCommand('insertHTML', false, html);
        },
    },
};
