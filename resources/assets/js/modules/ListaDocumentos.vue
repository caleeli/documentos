<template>
  <div>
    <h3>Lista de documentación</h3>
    <tree v-bind:tree="grid" class="table table-striped table-hover" @edit="gridEdit">
      <template slot="header">
        <div></div>
        <div>Nombre documento</div>
        <div style="white-space: pre">Fecha de envio</div>
      </template>
      <div vif="row.attributes">
        <div><i $class="row.attributes.icono"></i></div>
        <div>{row.attributes.documento}</div>
        <div>
          {dateFormat(row.attributes.fecha_envio)}
        </div>
      </div>
    </tree>
  </div>
</template>

<script>
  export default {
      props: {
      },
      data() {
          return {
              actionClass: 'btn-outline-secondary btn-sm',
              grid: {
                  name: '',
                  actions: {
                      collapse: {name: '', icon: 'fas fa-minus', iconActive: 'fas fa-plus', active: false},
                      edit: {name: '', icon: 'fas fa-edit'}
                  },
                  children: new ApiArray('/api/users/1/documentos'),
              }
          };
      },
      methods: {
        gridEdit() {
          
        }
      }
  }
</script>
