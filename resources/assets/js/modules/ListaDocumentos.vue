<template>
  <panel name="Lista de documentación" class="panel-primary">
    <grid v-model="data">
      <template slot="header" slot-scope="{data, options}">
        <th></th>
        <th>NOMBRE DOCUMENTO</th>
        <th>PROPIETARIO</th>
        <th></th>
      </template>
      <tr slot-scope="{row, options}" v-if="row.attributes">
        <td><i :class="row.attributes.icono"></i></td>
        <td style="min-width:50em"><document v-model="row.attributes.documento"/></td>
        <td>
          <div>
            <avatar v-model="row.relationships.propietario.attributes.fotografia" />
            {{row.relationships.propietario.attributes.name}}
          </div>
          <small>Enviado el <date-time v-model="row.attributes.fecha_envio" /></small>
        </td>
        <td><actions :actions="{a:{icon:'fa fa-save'}}" /></td>
        </tr>
    </grid>

  </panel>
</template>

<script>
  export default {
      data() {
          return {
              data: new ApiArray('/api/users/1/documentos?include=propietario'),
          };
      }
  }
</script>
