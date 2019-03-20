<template>
    <div class="base">
        <table border="0">
            <tr>
                <td style="font-size: 16px;">Eje de filas</td>
                <td style="font-size: 16px;"></td>
                <td style="font-size: 16px;">Eje de columnas</td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    <select class="form-control" v-model="rowsType">
                        <option value="destinatario">Destinatario</option>
                        <option value="gestion">Gestion</option>
                        <option value="clasificacion">Clasificación</option>
                    </select></td>
                <td style="font-size: 16px;">x</td>
                <td>
                    <select class="form-control" v-model="colsType">
                        <option value="destinatario">Destinatario</option>
                        <option value="gestion">Gestion</option>
                        <option value="clasificacion">Clasificación</option>
                    </select>
                </td>
                <td>
                    <button :disabled="rowsType===colsType" class="btn btn-primary" type="button" @click="generar">Generar</button>
                </td>
            </tr>
        </table>
        <div>
            <div class="space-box lg"></div>
            <template v-for="text in headers">
                <div class="data-box md"><span>{{text}}</span></div>
            </template>
        </div>
        <div>
            <div class="space-box lg"></div>
            <template v-for="text in headers">
                <div class="data-box red-data-box"><span><i class="fas fa-clock"></i></span></div>
                <div class="data-box green-data-box"><span><i class="fas fa-check"></i></span></div>
            </template>
        </div>
        <div v-for="(row,index) in rows" :key="index">
            <div class="data-box lg">{{row.text}}</div>
            <template v-for="cell in row.values">
                <div class="data-box red-data-box"><span>{{cell[0]}}</span></div>
                <div class="data-box green-data-box"><span>{{cell[1]}}</span></div>
            </template>
            <div class="data-box"><span>{{sumRow(row.values)}}</span></div>
        </div>
        <div>
            <div class="space-box lg"></div>
            <template v-for="(text,col) in headers">
                <div class="data-box"><span>{{sumCol(rows,col,0)}}</span></div>
                <div class="data-box"><span>{{sumCol(rows,col,1)}}</span></div>
            </template>
            <div class="data-box bold-data-box"><span>{{total(rows)}}</span></div>
        </div>
    </div>
</template>

<script>
    export default {
        path: "/HojaRutaReporteRapido",
        data() {
            let errores = {};
            return {
                data: new ApiObject('/api/reportes/create', errores),
                rowsType: 'destinatario',
                colsType: 'gestion',
                errores,
                headers: ["Eje Columnas"],
                rows: [
                    {"text": "Eje filas", "values": [[0, 0]]},
                ],
            };
        },
        methods: {
            total(array) {
                let total = 0;
                array.forEach(row => {
                    row.values.forEach(vals => {
                        total += vals[0];
                        total += vals[1];
                    });
                })
                return total;
            },
            generar() {
                this.data.callMethod('generarResumen', {'rowsType': this.rowsType, 'colsType': this.colsType})
                    .then(response => {
                        this.$set(this, 'headers', response.data.response.headers);
                        this.$set(this, 'rows', response.data.response.rows);
                    });
            },
            sumCol(array, iCol, i) {
                let total = 0;
                array.forEach(row => {
                    total+= row.values[iCol][i]
                })
                return total;
            },
            sumRow(array) {
                let t = 0;
                array.forEach(item => t += item[0] + item[1]);
                return t;
            },
        }
    };
</script>

<style scoped>
    .base {
        font-size:0px;
    }
    .data-box {
        font-size:16px;
        display:inline-block;
        height: 36px;
        line-height: 36px;
        text-align: center;
        border: 1px solid #979797;
        overflow: hidden;
        color: #000000;
        width: 60px;
    }
    .data-box span {
        display: inline-block;
        vertical-align: middle;
        line-height: normal;
    }
    .data-box.red-data-box {
        color: #D0021B;
        border-color: #D0021B;
        background-color: rgba(208,2,27,.3);
    }
    .data-box.green-data-box {
        color: #417505;
        border-color: #417505;
        background-color: rgba(65,117,5,.3);
    }
    .data-box.bold-data-box {
        font-weight: bold;
    }
    .data-box.lg {
        width: 180px;
    }
    .data-box.md {
        width: 120px;
    }
    .space-box.lg {
        font-size:16px;
        display:inline-block;
        border: 1px solid rgba(255,255,255,0);
        height: 36px;
        width: 180px;
    }
</style>
