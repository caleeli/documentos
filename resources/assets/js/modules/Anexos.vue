<template>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 pr-0">
            <table class="anexos">
                <tr>
                    <td>
                        <input class="form-control text-center" type="number" :value="getFjs" @input="setFjs">
                        <small class="form-text text-muted">fjs</small>
                    </td>
                    <td>
                        <input class="form-control text-center" type="number" :value="getArch" @input="setArch">
                        <small class="form-text text-muted">arch</small>
                    </td>
                    <td>
                        <input class="form-control text-center" type="number" :value="getAnillados" @input="setAnillados">
                        <small class="form-text text-muted">anillados</small>
                    </td>
                    <td>
                        <input class="form-control text-center" type="number" :value="getLegajo" @input="setLegajo">
                        <small class="form-text text-muted">legajo</small>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-6 col-xs-10 pl-sm-0">
            <table class="anexos">
                <tr>
                    <td>
                        <input class="form-control text-center" type="number" :value="getEjemplar" @input="setEjemplar">
                        <small class="form-text text-muted">ejemplar</small>
                    </td>
                    <td>
                        <input class="form-control text-center" type="number" :value="getEngrapado" @input="setEngrapado">
                        <small class="form-text text-muted">engrapado</small>
                    </td>
                    <td>
                        <input class="form-control text-center" type="number" :value="getCd" @input="setCd">
                        <small class="form-text text-muted">cd</small>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: String,
        },
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
                let ma = this.value ? this.value.match(regexp) : null;
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
                    'engrapado',
                    'cd',
                ];
                for (let index of tipos) {
                    let anexo = index == anexoA ? value : this.getAnexo(index);
                    if (anexo) {
                        anexoHojas.push(anexo + ' ' + index);
                    }
                }
                this.$emit('input', anexoHojas.join(', '));
            }
        },
        data: function() {
            return {};
        },
    }
</script>
