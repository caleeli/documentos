<template>
  <panel name="Formulario de remisión de información" class="panel-primary">
    <div class="form-group">
      <label>Referencia de la nota</label>
      <input type="text" placeholder="NOT - 001/2018" class="form-control">
    </div>
    <div class="form-group">
      <label>Empresa</label>
      <select-box type="single" placeholder="seleccione una empresa"
                  v-model="empresa"
                  v-bind:data="empresas"
                  id-field="id"
                  filter-by="attributes.cod_empresa,attributes.nombre_empresa,attributes.caracter,attributes.rubro,attributes.tipologia">
        <template slot-scope="{row,format}">
          <label v-html="format(row.attributes.cod_empresa)" class="badge"></label>
          <label v-html="format(row.attributes.nombre_empresa)"></label>
        </template>
      </select-box>
    </div>
    <div class="form-group">
      <label>Área o Unidad de Empresa Pública / Firma de Auditoría</label>
      <select-box type="single" placeholder="seleccione un area, unidad o firma"
                  v-model="unidad"
                  v-bind:data="unidades"
                  id-field="id"
                  filter-by="attributes.cod_firma,attributes.representante_legal">
        <template slot-scope="{row,format}">
          <label v-html="format(row.attributes.cod_firma)" class="badge"></label>
          <label v-html="format(row.attributes.representante_legal)"></label>
        </template>
      </select-box>
    </div>
    <div class="form-group">
      <label>Fecha y hora</label>
      <date-time v-model="v"/>
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
  </panel>
</template>

<script>
  export default {
      props: {
      },
      data() {
          return {
              v: '',
              actionClass: 'btn-outline-secondary btn-sm',
              empresa: '25',
              empresas: new ApiArray('/api/empresas'),
              unidad: '',
              unidades: new ApiArray('/api/firmas')
          };
      },
      methods: {
          gridEdit() {

          }
      }
  }
</script>
