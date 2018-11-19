<template>
    <panel v-if="data.attributes" :name="'HOJA DE RUTA - No HR - SCEP: ' + data.attributes.numero" class="panel-primary">
           <div class="row">
            <div class="col-12"><h4>Tipo HR: {{data.attributes.tipo}}</h4></div>
        </div>
        <div class="form-group row">
            <div class="col-1"><label>Fecha de recepción:</label></div>
            <div class="col-11"><datetime type="date" v-model="data.attributes.fecha" /></div>
        </div>
        <div class="form-group row">
            <div class="col-1"><label>Procedencia:</label></div>
            <div class="col-11">
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
            <div class="col-1"><label>Referencia:</label></div>
            <div class="col-11"><text-box :data="hojasExternas" v-model="data.attributes.referencia" /></div>
        </div>
        <div class="form-group row">
            <div class="col-1"><label>Destinatario:</label></div>
            <div class="col-11">
                <select-box :data="destinatarios" v-model="data.attributes.destinatario"
                    filter-by="attributes.nombre_completo">
                    <template slot-scope="{row,format}">
                        <label v-html="format(row.attributes.nombre_completo)"></label>
                    </template>
                </select-box>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1"><label>N° de control:</label></div>
            <div class="col-11"><input class="form-control" type="text" v-model="data.attributes.nro_de_control" /></div>
        </div>
        <div class="form-group row">
            <div class="col-1"><label>Anexo Hojas:</label></div>
            <div class="col-11"></div>
        </div>
    </panel>
</template>

<script>
    export default {
        data() {
            return {
                data: new ApiObject('/api/hoja_rutas/create?factory=externa'),
                procedencias: new ApiArray('/api/empresas'),
                destinatarios: new ApiArray('/api/users'),
                hojasExternas: new ApiArray('/api/hoja_rutas?sort=-id&filter[]=where,tipo,=,"externa"&per_page=5000')
            };
        }
    };
</script>
