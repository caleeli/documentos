<template>
    <panel name="Verificacion Inf. Final" class="panel-primary">
        <table border="0">
            <td>Formulario de Revision de Credito</td>

            <br>
            <tr>
                <td>1. Revisión de Documentacion</td>
                <td></td>
                <td> Observaciones</td>
            </tr>
            <tr>
                <td>1.1. Del Cliente</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>1.1.1. Formulario de Solicitud de Crédito</td>
                <td>
                    <select>
                        <option value="volvo">N/A</option>
                        <option value="saab">Cumple</option>
                        <option value="mercedes">No Cumple</option>
                        <option value="audi">Parcial</option>
                    </select> 
                </td>
                <td> <input type="text" name="campo1"></td>
            </tr>
            <tr>
                <td>1.1.2. Croquis de Domicilio</td>
                <td>
                    <select>
                        <option value="volvo">N/A</option>
                        <option value="saab">Cumple</option>
                        <option value="mercedes">No Cumple</option>
                        <option value="audi">Parcial</option>
                    </select> 
                </td>
                <td> <input type="text" name="campo1"></td>
            </tr>
            <tr>
                <td>1.1.3. Fotocopia de CI</td>
                <td>
                    <select>
                        <option value="volvo">N/A</option>
                        <option value="saab">Cumple</option>
                        <option value="mercedes">No Cumple</option>
                        <option value="audi">Parcial</option>
                    </select> 
                </td>
                <td> <input type="text" name="campo1"></td>
            </tr>
            <tr>
                <td>1.1.4. Formulario de Verificación del Buro</td>
                <td>
                    <select>
                        <option value="volvo">N/A</option>
                        <option value="saab">Cumple</option>
                        <option value="mercedes">No Cumple</option>
                        <option value="audi">Parcial</option>
                    </select> 
                </td>
                <td> <input type="text" name="campo1"></td>
            </tr>
            <tr>
                <td>1.1.5. Fotocopia de CI Cónyuge</td>
                <td>
                    <select>
                        <option value="volvo">N/A</option>
                        <option value="saab">Cumple</option>
                        <option value="mercedes">No Cumple</option>
                        <option value="audi">Parcial</option>
                    </select> 
                </td>
                <td> <input type="text" name="campo1"></td>
            </tr>
            <tr>
                <td>1.1.6. Croquis del trabajo o negocio</td>
                <td>
                    <select>
                        <option value="volvo">N/A</option>
                        <option value="saab">Cumple</option>
                        <option value="mercedes">No Cumple</option>
                        <option value="audi">Parcial</option>
                    </select> 
                </td>
                <td> <input type="text" name="campo1"></td>
            </tr>
            <tr>
                <td>1.2. De la Operación</td>
                <td></td>
            </tr>	

            <tr>
                <td>1.2.1. Formulario de Ingresos y egresos</td>
                <td>
                    <form action="">
                        <input type="radio" name="gender" value="male"> Cumple<br>
                        <input type="radio" name="gender" value="female">No Cumple<br>
                        <input type="radio" name="gender" value="other"> N/A <br>
                    </form>
                </td>
                <td> <input type="text" name="campo1"></td>
            </tr>
            <tr>
                <td>1.2.2. Formulario Evaluación Economica</td>
                <td>
                    <form action="">
                        <input type="radio" name="gender" value="male"> Cumple<br>
                        <input type="radio" name="gender" value="female">No Cumple<br>
                        <input type="radio" name="gender" value="other"> N/A <br>
                    </form>
                </td>
                <td> <input type="text" name="campo1"></td>
            </tr>
        </table>

        <button type="button" class="btn btn-success" @click="completar">Completar</button>
    </panel>
</template>

<script>
    export default {
        data() {
            return {
            };
        },
        methods: {
            completar() {
                this.$router.push({path: '/RevisionDeCarpeta', query:this.$route.query});
            }
        }
    };
</script>
