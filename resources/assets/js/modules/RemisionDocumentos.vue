<template>
  <div class="col">
    <h2>Formulario de remisión de información</h2>
    <div class="form-group">
      <label>Referencia de la nota</label>
      <input type="text" placeholder="NOT - 001/2018" class="form-control">
    </div>
    <div class="form-group">
      <label>Empresa</label>
      <select-box type="single" placeholder="seleccione una empresa" class="form-control"
                  api="http://subcep.com/api/UserAdministration/empresas"><label>{row.attributes.nombre_empresa}</label></select-box>
    </div>
    <div class="form-group">
      <label>Área o Unidad de Empresa Pública / Firma de Auditoría</label>
      <input type="text" placeholder="Unidad de auditoria" class="form-control">
    </div>
    <div class="form-group">
      <div><label>Seleccione el Tipo de Referencia</label></div>
      <div class="row">
        <div class="col-6">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_referencia" value="option1" checked="">
              1. Evaluación de Consistencias
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_referencia" value="option1" checked="">
              2. Auditorías
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_referencia" value="option1" checked="">
              3. Supervisiones
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_referencia" value="option1" checked="">
              4. Relevamientos de Información
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_referencia" value="option1" checked="">
              5. Contrataciones Directas
            </label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_referencia" value="option1" checked="">
              6. Evaluación de Informes de UAI's
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_referencia" value="option1" checked="">
              7. Evaluación de Informes de POA y PEI de UAI
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_referencia" value="option1" checked="">
              8. Solicitudes y Denuncias
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_referencia" value="option1" checked="">
              9. Tareas Administrativas
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_referencia" value="option1" checked="">
              10. Otros
            </label>
          </div>
        </div>
      </div>
      <input type="text" placeholder="otro..." class="form-control">
    </div>
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
