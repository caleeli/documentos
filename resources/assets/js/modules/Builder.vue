<template>
  <div class="col">
    <h2>Builder</h2>
    <div class="form-group">
      <label>api url</label>
      <input type="text" placeholder="/api/..." class="form-control" v-model="api">
    </div>
    <div>
      <button type="button" class="btn btn-outline-primary builder-preview">
        <div class="badge badge-primary">grid</div>
        <grid v-model="data" class="table table-striped table-hover">
          <template slot="header">
            <div v-for="(vv, aa) in data[0].attributes">{{aa}}</div>
          </template>
          <div vif="row.attributes">
            <div v-for="(vv, aa) in data[0].attributes">{{'{row.attributes.'+aa+'}'}}</div>
          </div>
        </grid>
      </button>
      <button type="button" class="btn btn-outline-primary builder-preview">
        <div class="badge badge-primary">select-box</div>
        <div>
          <select-box v-bind:data="data"><span>{row.attributes.name}</span></select-box>
        </div>
      </button>
    </div>
  </div>
</template>

<script>
  const templates = {
      grid: `<grid v-model="data" class="table table-striped table-hover">
          <template slot="header">
            <div v-for="(vv, aa) in data[0].attributes">{{aa}}</div>
          </template>
          <div vif="row.attributes">
            <div v-for="(vv, aa) in data[0].attributes">{{'{row.attributes.'+aa+'}'}}</div>
          </div>
        </grid>`
  };
  export default {
      props: {
      },
      data() {
          return {
              api: '/api/users',
              type: 'grid'
          };
      },
      computed: {
          data() {
              return new ApiArray(this.api);
          }
      },
      methods: {
          tplGrid() {
              return `<grid v-model="data" class="table table-striped table-hover">
</grid>`;
          }
      }
  }
</script>

<style lang="scss">
  button.builder-preview{
      zoom: 1%;
      width: 20em;
      overflow: hidden;
      height: 12em;
      position: relative;
  }
  button.builder-preview .badge{
      text-transform:  uppercase;
  }
</style>

<!--
Conceptos:
Templeta HTML/Vue
Bucles, condiciones
Parametros de generacion de la templeta
La templeta sera editable
Puntos de insersion

TEMPLERA SEMILLA:
F1: La templeta se la puede hacer con la funcionalidad de templetas de VueJS
<grid v-model="data" class="table table-striped table-hover">
  <template slot="header">
    <div v-for="(vv, aa) in data[0].attributes">{{aa}}</div>
  </template>
  <div vif="row.attributes">
    <div v-for="(vv, aa) in data[0].attributes">{{'{row.attributes.'+aa+'}'}}</div>
  </div>
</grid>

PRIMERA GENERACION:
F2: Es posible obtener el resultado de la templeta
<grid v-model="data" class="table table-striped table-hover">
  <template slot="header">
    <div>campo1</div>
    <div>campo2</div>
    <div>campo3</div>
  </template>
  <div vif="row.attributes">
    <div>{row.attributes.campo1}</div>
    <div>{row.attributes.campo2}</div>
    <div>{row.attributes.campo3}</div>
  </div>
</grid>

PRIMERA EDICION:
F3: Se cuenta con un editor de texto
<grid v-model="data" class="table table-striped table-hover">
  <template slot="header">
    <div>Campo 1</div>
    <div>Campo 2</div>
  </template>
  <div vif="row.attributes">
    <div>{row.attributes.campo1}</div>
    <div>{row.attributes.campo3}</div>
  </div>
</grid>

Selecciono "row.attributes.campo3":
F3: Es posible capturar el texto seleccionado
F4: Click en el boton <datetime>, entonces reemplaza {row.attributes.campo3} por:
  F5: Aumenta la seleccion actual incluyendo: {}
  F6: Identifica si se encuentra dentro de una subtempleta o no
  <datetime $v-model="row.attributes.campo3" />

  Despues de insertar el componente datetime

  <grid v-model="data" class="table table-striped table-hover">
    <template slot="header">
      <div>Campo 1</div>
      <div>Campo 2</div>
    </template>
    <div vif="row.attributes">
      <div>{row.attributes.campo1}</div>
      <div><datetime $v-model="row.attributes.campo3" /></div>
    </div>
  </grid>

-->