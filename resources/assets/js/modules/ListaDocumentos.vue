<template>
  <panel name="Lista de documentación">
      <grid v-model="data" class="table table-striped table-hover">
      <template slot="header">
        <div></div>
        <div>Nombre documento</div>
        <div>Propietario</div>
        <div></div>
      </template>
      <div vif="row.attributes">
        <div><i $class="row.attributes.icono"></i></div>
        <div style="min-width:50em"><document $v-model="row.attributes.documento"/></div>
        <div>
          <div>
            <avatar $v-model="row.relationships.propietario.attributes.fotografia" />
            {row.relationships.propietario.attributes.name}
          </div>
          <small>Enviado el <date-time $v-model="row.attributes.fecha_envio" /></small>
        </div>
        <div><actions $actions="{a:{icon:'fa fa-save'}}" /></div>
      </div>
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
