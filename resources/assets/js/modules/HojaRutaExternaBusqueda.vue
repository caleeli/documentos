<template>
  <panel name="EXTERNA" class="panel-primary">
    <grid v-model="data">
      <template slot="header">
        <th width="10%">Nro HR&#x2011;SCEP</th>
        <th width="10%">Hoja de Ruta</th>
        <th width="5%">Gestión</th>
        <th width="20%">Referencia</th>
        <th width="20%">Procedencia</th>
        <th width="20%">Destinario Actual</th>
        <th width="5%">Fecha de derivación</th>
        <th width="5%">Estado de Conclusión</th>
        <th width="5%">Fecha de Conclusión</th>
        <th></th>
      </template>
      <tr slot-scope="{row, options}">
        <td>SCEP&#x2011;{{row.attributes.numero}}</td>
        <td>{{row.attributes.nro_de_control}}</td>
        <td>{{row.attributes.gestion}}</td>
        <td>{{row.attributes.referencia}}</td>
        <td>{{row.attributes.procedencia}}</td>
        <td><avatar v-if="row.attributes.usuario_destinatario" v-model="row.attributes.usuario_destinatario" field="fotografia" />{{row.attributes.usuario_destinatario ? (row.attributes.usuario_destinatario.attributes.nombres + ' ' + row.attributes.usuario_destinatario.attributes.apellidos) : ''}}</td>
        <td><datetime type="date" v-model="row.attributes.fecha_derivacion" read-only /></td>
        <td>{{row.attributes.estado}}</td>
        <td><datetime type="date" v-model="row.attributes.conclusion" read-only /></td>
      </tr>
    </grid>
  </panel>
</template>

<script>
  export default {
      data() {
          return {
              data: new ApiArray('/api/hoja_rutas?sort=-id'),
          };
      }
  }
</script>
