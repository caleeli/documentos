<template>
  <panel :name="titulo" class="panel-primary">
    <div class="row" v-if="tarea.attributes">
      <div class="col-lg-5">
        <dl class="dl-horizontal">
          <dt>Estado:</dt>
          <dd>
            <span class="badge badge-primary">{{tarea.attributes.tar_estado}}</span>
          </dd>
          <div style="height: 4px;"></div>
          <dt>Prioridad:</dt>
          <dd>
            <span v-bind:class="classPriodidad(tarea)">{{labelPrioridad(tarea)}}</span>
          </dd>
          <dt>Creado por:</dt>
          <dd>
            <avatar :user="tarea.relationships.tar_creador" />
            {{tarea.relationships.tar_creador ? tarea.relationships.tar_creador.attributes.nombres + ' ' + tarea.relationships.tar_creador.attributes.apellidos : ''}}
          </dd>
          <dt>Asignado a:</dt>
          <dd>
            <div v-for="usuario in tarea.relationships.usuarios" :key="usuario.id">
              <avatar :user="usuario" />
              {{usuario ? usuario.attributes.nombres + ' ' + usuario.attributes.apellidos : ''}}
            </div>
          </dd>
        </dl>
      </div>
      <div class="col-lg-7" id="cluster_info">
        <dl class="dl-horizontal">
          <dt>Creación:</dt>
          <dd>{{tarea.attributes.fecha_registro}}</dd>
          <dt>Última actualización:</dt>
          <dd>{{tarea.attributes.fecha_modificacion}}</dd>
          <dt>Tiempo asignado:</dt>
          <dd>{{tarea.relationships.derivacion.attributes.dias_plazo}} días</dd>
          <dt>Tiempo disponible:</dt>
          <dd>
            <pie-svg :value="tiempoReloj(tarea)"></pie-svg>
            {{ diasPasados(tarea) }}
          </dd>
        </dl>
      </div>
    </div>
  </panel>
</template>

<script>
import moment from "moment";

const apiBase = "/api/adm_tareas";
const colores = {
  Completado: "badge badge-success",
  default: "badge badge-warning"
};
const iconos = {
  Completado: "fa fa-check",
  default: "fa fa-clock"
};
const colorPrioridades = {
  1: "badge badge-danger",
  2: "badge badge-warning",
  3: "badge badge-success",
  default: "badge badge-light"
};
const prioridades = {
  1: "Alta",
  2: "Media",
  3: "Baja"
};

export default {
  path: "/Tarea/:id",
  methods: {
    seleccionaTarea() {},
    tiempoReloj(tarea) {
      return Math.min(
        100,
        Math.round(
          (100 *
            moment().diff(
              moment(tarea.attributes.tar_fecha_derivacion),
              "days"
            )) /
            tarea.relationships.derivacion.attributes.dias_plazo
        )
      );
    },
    diasPasados(tarea) {
      return moment(tarea.attributes.tar_fecha_derivacion).fromNow();
    },
    labelPrioridad(tarea) {
      return (
        prioridades[tarea.attributes.tar_prioridad] ||
        tarea.attributes.tar_prioridad
      );
    },
    classPriodidad(tarea) {
      return (
        colorPrioridades[tarea.attributes.tar_prioridad] ||
        colorPrioridades.default
      );
    },
    isOwnedByUser(tarea) {
      return true;
    },
    esUsuarioGerente() {
      return true;
    },
    usuariosAsignados(tarea) {
      return [];
    },
    iconoEstado(tarea) {
      return iconos[tarea.attributes.tar_estado] || iconos.default;
    },
    classEstado(tarea) {
      return colores[tarea.attributes.tar_estado] || colores.default;
    },
    listarTareas() {},
    buscarTarea() {},
    avancePasosPorcentaje() {
      return 1;
    }
  },
  computed: {
    titulo() {
      return this.tarea.attributes
        ? this.tarea.attributes.tar_codigo +
            " - " +
            this.tarea.attributes.tar_descripcion
        : "...";
    }
  },
  data() {
    return {
      tarea: new ApiObject(
        "/api/tarea/" +
          this.$route.params.id +
          "?include=tar_creador,derivacion,usuarios"
      )
    };
  },
  watch: {}
};
</script>

<style scoped>
dt {
  display: inline-block;
  width: 30%;
  text-align: right;
}
dd {
  display: inline-block;
  width: 60%;
  text-align: left;
}
</style>
