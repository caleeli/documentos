<template>
        <panel :name="'PERSONAS'" class="panel-primary">
            <div class="container">
                <div class="row">
                    <div class="col-12"><h4>Registro Persona:</h4> </div>
                </div>
                <error v-model="erroresPersona" property="message"></error>
                <div class="form-group row">
                    <div :class="colLabel"><label>Tipo Persona:</label></div>
                    <div :class="colField">
                        <template v-for="(tipoPersona, index) in tipoPersonas">
                            <div class="row">
                                <div class="radio col-6">
                                    <label>
                                        <input type="radio" name="per_tipo_persona"
                                            :value="tipoPersona.codigo"
                                            v-model="persona.attributes.per_tipo_persona"
                                            >
                                        {{tipoPersona.descripcion}}
                                    </label>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="form-group row">
                    <div :class="colLabel"><label>{{ persona.attributes.per_tipo_persona=='natural' ? 'Nombres:' : 'Razon Social:' }}</label></div>
                    <div :class="colField">
                        <input class="form-control" type="text" v-model="persona.attributes.per_nombres" />
                        <error v-model="erroresPersona" property="errors.nombres"></error>
                    </div>
                </div>
                <div v-if="persona.attributes.per_tipo_persona=='natural'" class="form-group row">
                    <div :class="colLabel"><label>Apellidos:</label></div>
                    <div :class="colField">
                        <input class="form-control" type="text" v-model="persona.attributes.per_apellidos" />
                        <error v-model="erroresPersona" property="errors.apellidos"></error>
                    </div>
                </div>
                <div class="form-group row">
                    <div :class="colLabel"><label>{{ persona.attributes.per_tipo_persona=='natural' ? 'CI:' : 'NIT:' }}</label></div>
                    <div :class="colField">
                        <input class="form-control" type="text" v-model="persona.attributes.per_ci_nit" />
                        <error v-model="erroresPersona" property="errors.ci_nit"></error>
                    </div>
                </div>
                <div class="form-group row">
                    <div :class="colLabel"></div>
                    <div :class="colField">
                        <button type="button" class="btn btn-primary" @click="savePersona">Guardar</button>
                    </div>
                </div>
            </div>
        </panel>
</template>

<script>
    export default {
        //path: "/HojaRuta/:type/:id",
        path: "/Persona/:id",
        methods: {
            getUrlBase() {
                return "/api/persona";
            },
            savePersona() {

                if (this.persona.id) {
                    this.persona.putToAPI(this.getUrlBase() + "/" + this.persona.id).then((response) => {
                        this.$router.push({params: {id: response.data.data.id}});
                    });
                } else {
                    this.persona.callMethod('getSecuencia')
                        .then(response => {
                            this.persona.attributes.per_id = response.data.response;
                            this.persona.postToAPI(this.getUrlBase()).then((response) => {
                                //this.$router.push({params: {id: response.data.data.id}});
                                //this.$emit('respPersona', this.persona.attributes.per_nombres +  ' ' + this.persona.attributes.per_apellidos + '-' + this.persona.attributes.per_ci_nit);
                                this.$router.push({path: '/HojaRuta/create'});
                            });
                    });
                }

            },
            getIdURL() {
                //return isNaN(this.$route.params.id) ? 'create?factory=' + this.$route.params.type + '&include=userAdd,userMod' : this.$route.params.id + '?include=userAdd,userMod';
                return isNaN(this.$route.params.id) ? 'create?' : this.$route.params.id + '';
            },
        },
        data() {
            const erroresPersona = {};
            return {
                persona: new ApiObject(this.getUrlBase() + '/' + this.getIdURL(), erroresPersona).loadFromAPI(),
                erroresPersona: erroresPersona,
                tipoPersonas: [  {codigo: 'natural', descripcion: 'Natural'}, 
                                 {codigo: 'juridica', descripcion: 'Juridica'}
                                ],
            };
        },
        watch: {
            '$route.params.id'() {
                this.persona.loadFromAPI(this.getUrlBase() + '/' + this.getIdURL());
            },
        },
        mounted() {
            this.persona.loadFromAPI();
        }
    };
</script>

<style lang="scss">
    .anexos tr td {
    }
    .anexos tr td small {
    }
    .selected-item {
        font-size: 1rem;
        pointer-events: all!important;
        cursor: pointer;
    }
    .selected-item:hover {
        text-decoration: underline;
    }
</style>
