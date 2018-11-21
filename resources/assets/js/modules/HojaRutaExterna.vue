<template>
    <panel v-if="data.attributes" :name="'HOJA DE RUTA - No HR - SCEP: ' + data.attributes.numero" class="panel-primary">
           <div class="row">
            <div class="col-12"><h4>Tipo HR: {{data.attributes.tipo}}</h4></div>
        </div>
        <div class="form-group row">
            <div :class="colLabel"><label>Fecha de recepción:</label></div>
            <div :class="colField"><datetime type="date" v-model="data.attributes.fecha" /></div>
        </div>
        <div class="form-group row">
            <div :class="colLabel"><label>Procedencia:</label></div>
            <div :class="colField">
                <select-box :data="procedencias" v-model="data.attributes.procedencia"
                    filter-by="attributes.cod_empresa,attributes.nombre_empresa">
                    <template slot-scope="{row,format}">
                        <label v-html="format(row.attributes.cod_empresa)" class="badge"></label>
                        <label v-html="format(row.attributes.nombre_empresa)"></label>
                    </template>
                </select-box>
            </div>
        </div>
        <div class="form-group row">
            <div :class="colLabel"><label>Referencia:</label></div>
            <div :class="colField"><text-box :data="hojasExternas" v-model="data.attributes.referencia" /></div>
        </div>
        <div class="form-group row">
            <div :class="colLabel"><label>Destinatario:</label></div>
            <div :class="colField">
                <select-box :data="destinatarios" v-model="data.attributes.destinatario"
                    filter-by="attributes.nombre_completo">
                    <template slot-scope="{row,format}">
                        <label v-html="format(row.attributes.nombre_completo)"></label>
                    </template>
                </select-box>
            </div>
        </div>
        <div class="form-group row">
            <div :class="colLabel"><label>N° de control:</label></div>
            <div :class="colField"><input class="form-control" type="text" v-model="data.attributes.nro_de_control" /></div>
        </div>
        <div class="form-group row">
            <div :class="colLabel"><label>Anexo Hojas:</label></div>
            <div :class="colField">
                <div class="row">
                    <div class="col-1 text-center">
                        <input class="form-control text-center" type="number" :value="getFjs" @input="setFjs">
                        <small class="form-text text-muted">fjs</small>
                    </div>
                    <div class="col-1 text-center">
                        <input class="form-control text-center" type="number" :value="getArch" @input="setArch">
                        <small class="form-text text-muted">arch</small>
                    </div>
                    <div class="col-1 text-center">
                        <input class="form-control text-center" type="number" :value="getAnillados" @input="setAnillados">
                        <small class="form-text text-muted">anillados</small>
                    </div>
                    <div class="col-1 text-center">
                        <input class="form-control text-center" type="number" :value="getLegajo" @input="setLegajo">
                        <small class="form-text text-muted">legajo</small>
                    </div>
                    <div class="col-1 text-center">
                        <input class="form-control text-center" type="number" :value="getEjemplar" @input="setEjemplar">
                        <small class="form-text text-muted">ejemplar</small>
                    </div>
                    <div class="col-1 text-center">
                        <input class="form-control text-center" type="number" :value="getEngrapado" @input="setEngrapado">
                        <small class="form-text text-muted">engrapado</small>
                    </div>
                    <div class="col-1 text-center">
                        <input class="form-control text-center" type="number" :value="getCd" @input="setCd">
                        <small class="form-text text-muted">cd</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div :class="colLabel"><label>Clasificación:</label></div>
            <div :class="colField">
                <div class="radio" v-for="clasificacion in clasificacionHojasRuta">
                    <label>
                        <input type="radio" name="hoja_edit_tipo"
                               :value="clasificacion.attributes.sigla"
                               v-model="data.attributes.tipo_hoja">
                        {{clasificacion.attributes.nombre}}
                    </label>
                </div>
            </div>
        </div>
    </panel>
</template>

<script>
    export default {
        computed: {
            getFjs() {
                return this.getAnexo("fjs");
            },
            getArch() {
                return this.getAnexo("arch");
            },
            getAnillados() {
                return this.getAnexo("anillados");
            },
            getLegajo() {
                return this.getAnexo("legajo");
            },
            getEjemplar() {
                return this.getAnexo("ejemplar");
            },
            getEngrapado() {
                return this.getAnexo("engrapado");
            },
            getCd() {
                return this.getAnexo("cd");
            },
        },
        methods: {
            setFjs(event) {
                this.setAnexo('fjs', event.target.value);
            },
            setArch(event) {
                this.setAnexo('arch', event.target.value);
            },
            setAnillados(event) {
                this.setAnexo('anillados', event.target.value);
            },
            setLegajo(event) {
                this.setAnexo('legajo', event.target.value);
            },
            setEjemplar(event) {
                this.setAnexo('ejemplar', event.target.value);
            },
            setEngrapado(event) {
                this.setAnexo('engrapado', event.target.value);
            },
            setCd(event) {
                this.setAnexo('cd', event.target.value);
            },
            getAnexo(index) {
                let regexp = new RegExp("(\\d+)\\s+" + index);
                let ma = this.data.attributes.anexo_hojas ? this.data.attributes.anexo_hojas.match(regexp) : null;
                return ma ? ma[1] : "";
            },
            setAnexo(anexoA, value) {
                const anexoHojas = [];
                const tipos = [
                    'fjs',
                    'arch',
                    'anillados',
                    'legajo',
                    'ejemplar',
                    'engrapad',
                    'cd',
                ];
                for (let index of tipos) {
                    let anexo = index == anexoA ? value : this.getAnexo(index);
                    if (anexo) {
                        anexoHojas.push(anexo + ' ' + index);
                    }
                }
                this.data.attributes.anexo_hojas = anexoHojas.join(', ');
            }
        },
        data() {
            return {
                data: new ApiObject('/api/hoja_rutas/create?factory=externa'),
                procedencias: new ApiArray('/api/empresas'),
                destinatarios: new ApiArray('/api/users'),
                hojasExternas: new ApiArray('/api/hoja_rutas?sort=-id&filter[]=where,tipo,=,"externa"&per_page=5000'),
                clasificacionHojasRuta: new ApiArray('/api/hoja_ruta_clasificacion'),
            };
        }
    };
</script>
