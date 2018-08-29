<template>
  <div>
    <h2>Lista de documentación</h2>
    <tree v-bind:tree="grid" class="table table-striped table-hover" @edit="gridEdit">
      <template slot="header">
        <div></div>
        <div>Nombre documento</div>
        <div style="white-space: pre">Fecha de envio</div>
      </template>
      <div><i $class="row.icon"></i></div>
      <div>{row.nombre}</div>
      <div>
        {dateFormat(row.fecha_envio)}
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
                  children: [
                      {
                          icon: 'fas fa-file',
                          nombre: 'Documentos',
                          fecha_envio: '2018-08-01T04:00:00.000Z',
                          $collapsed: false,
                          actions: {
                              collapse: {name: '', icon: 'fas fa-minus', iconActive: 'fas fa-plus', active: false}
                          },
                      },
                      {
                          icon: 'fa fa-file-excel text-success',
                          nombre: 'Balance General',
                          fecha_envio: '2018-08-01T04:00:00.000Z',
                          actions: {
                              collapse: {name: '', icon: 'fas fa-minus', iconActive: 'fas fa-plus', active: false}
                          },
                      },
                      {
                          icon: 'fa fa-file-excel text-success',
                          nombre: 'Estado de resultados',
                          fecha_envio: '2018-08-01T04:00:00.000Z',
                          actions: {
                              collapse: {name: '', icon: 'fas fa-minus', iconActive: 'fas fa-plus', active: false}
                          },
                      },
                      {
                          icon: 'fa fa-file-word text-primary',
                          nombre: 'Carta de respuesta',
                          fecha_envio: '2018-08-01T04:00:00.000Z',
                          $collapsed: false,
                          actions: {
                              collapse: {name: '', icon: 'fas fa-minus', iconActive: 'fas fa-plus', active: false}
                          },
                      },
                      {
                          icon: 'fa fa-file-pdf text-danger',
                          nombre: 'Carta de solicitud',
                          fecha_envio: '2018-08-01T04:00:00.000Z',
                          $collapsed: false,
                          actions: {
                              collapse: {name: '', icon: 'fas fa-minus', iconActive: 'fas fa-plus', active: false}
                          },
                      }
                  ]
              }
          };
      },
      methods: {
        gridEdit() {
          
        }
      }
  }
</script>
