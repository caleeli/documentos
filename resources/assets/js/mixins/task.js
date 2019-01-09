const BasePath = '/Process/';

export default {
    beforeRouteLeave(to, from, next) {
        const continueProcess = to.fullPath.substr(0, BasePath.length) === BasePath;
        if (!continueProcess) {
            this.$processCancel();
        }
        next();
    },
    methods: {
        $processCancel(data){
            Process.cancel(this.$route.query, data);
        },
        /**
         * Devuelve una ruta para completar una tarea.
         *
         * @param {object} data
         *
         * @returns {route}
         */
        $processCompleteRoute(data) {
            const instance = this.$route.query.instance;
            const token = this.$route.query.token;
            return {
                path: BasePath + 'Complete/' + instance + '/' + token,
                query: data,
            }
        }
    }
};
