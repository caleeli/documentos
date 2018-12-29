export default {
    data() {
        return {
            /**
             * Define el componente vuejs que se mostrara al seleccionar
             * un tipo de elemento seleccionado
             */
            inspector: {
                comment: {
                    component: 'Comentario',
                },
            },
            /**
             * Se encargan de cargar los datos del elemento seleccionado
             */
            handlers: {
                A(element) {
                    return this.parseConfig({type: 'comment', comentarios: []}, element);
                },
            },
        };
    },
    methods: {
        comentario() {
            window.document.execCommand('createLink', false, '#comment');
        },
    },
};
