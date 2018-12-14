<template>
    <panel name="Asignación de la muestra" class="panel-primary">
        <grid v-model="data"
              filter-by="attributes.DESCRIP_AGENCIA
              ">
            <template slot="header">
                <th>Asignacion</th>
                <th>CODIGO_OFI</th>
                <th>DESCRIP_AGENCIA</th>
                <th>CODIGO_OPE</th>
                <th>TIPO_CLIENTE</th>
                <th>DESCRIP_OPERACION</th>
                <th>CODIGO_MON</th>
                <th>FECHA_DESE</th>
                <th>TASA_INTER</th>
                <th>SALDO</th>
                <th>SALDO_BOL</th>
                <th>SALDO_DOL</th>
                <th>ESTADO_OPE</th>
                <th>CODIGO_ASE</th>
                <th>NOMBRE_USU</th>
                <th>CODIGO_GRU</th>
                <th>NOMBRE_BANCA</th>
                <th>CODIGO_CLI</th>
                <th>VALOR_DOCU</th>
                <th>NOMBRE_COM</th>
                <th>SEXO_CLIEN</th>
                <th>CODIGO_EST</th>
                <th>FECHA_NACI</th>
                <th>SECUENCIA_</th>
                <th>FECHA_INSC</th>
                <th>DIAS_MORA</th>
                <th>dias_mora_actual</th>
                <th>MONTO_APRO</th>
            </template>
            <tr slot-scope="{row, options, format}">
                <td>
                    <select class="form-control">
                        <option></option>
                        <option>Auditor 1</option>
                        <option>Auditor 2</option>
                        <option>Auditor 3</option>
                    </select>
                </td>
                <td>{{row.attributes.CODIGO_OFI}}</td>
                <td v-html="format(row.attributes.DESCRIP_AGENCIA)"></td>
                <td>{{row.attributes.CODIGO_OPE}}</td>
                <td>{{row.attributes.TIPO_CLIENTE}}</td>
                <td>{{row.attributes.DESCRIP_OPERACION}}</td>
                <td>{{row.attributes.CODIGO_MON}}</td>
                <td>{{row.attributes.FECHA_DESE}}</td>
                <td>{{row.attributes.TASA_INTER}}</td>
                <td>{{row.attributes.SALDO}}</td>
                <td>{{row.attributes.SALDO_BOL}}</td>
                <td>{{row.attributes.SALDO_DOL}}</td>
                <td>{{row.attributes.ESTADO_OPE}}</td>
                <td>{{row.attributes.CODIGO_ASE}}</td>
                <td>{{row.attributes.NOMBRE_USU}}</td>
                <td>{{row.attributes.CODIGO_GRU}}</td>
                <td>{{row.attributes.NOMBRE_BANCA}}</td>
                <td>{{row.attributes.CODIGO_CLI}}</td>
                <td>{{row.attributes.VALOR_DOCU}}</td>
                <td>{{row.attributes.NOMBRE_COM}}</td>
                <td>{{row.attributes.SEXO_CLIEN}}</td>
                <td>{{row.attributes.CODIGO_EST}}</td>
                <td>{{row.attributes.FECHA_NACI}}</td>
                <td>{{row.attributes.SECUENCIA_}}</td>
                <td>{{row.attributes.FECHA_INSC}}</td>
                <td>{{row.attributes.DIAS_MORA}}</td>
                <td>{{row.attributes.dias_mora_actual}}</td>
                <td>{{row.attributes.MONTO_APRO}}</td>
                <td></td>
            </tr>
        </grid>

        <button type="button" class="btn btn-success" @click="completar">Completar</button>
    </panel>
</template>

<script>
    export default {
        data() {
            return {
                data: new ApiArray('/api/operacion?per_page=200')
            };
        },
        methods: {
            completar() {
                Process.completeTask(this.$route.query);
            }
        }
    };
</script>
