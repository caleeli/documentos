<template>
  <div>
    <h3>Lista de documentación</h3>
    <grid v-bind:data="data" class="table table-striped table-hover">
      <template slot="header">
        <div></div>
        <div>Nombre documento</div>
        <div>Fecha de envio</div>
      </template>
      <div vif="row.attributes">
        <div><i $class="row.attributes.icono"></i></div>
        <div style="min-width:50em">{row.attributes.documento}</div>
        <div><date-time $v-model="row.attributes.fecha_envio" /></div>
      </div>
    </grid>
  </div>
</template>

<script>
  export default {
      props: {
      },
      data() {
          return {
              data: new ApiArray('/api/users/1/documentos'),
          };
      },
      methods: {
      }
  }
</script>
