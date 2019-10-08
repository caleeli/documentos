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
          <dd>{{tarea.relationships.derivacion.attributes.dias_plazo}} días, {{ diasPasados(tarea) }}</dd>
          <dt>Tiempo cumplimiento:</dt>
          <dd>
            <pie-svg :value="tiempoReloj(tarea)"></pie-svg>
            {{ tiempoDisponible(tarea) }}
          </dd>
        </dl>
      </div>
    </div>
    <div class="row" v-if="tarea.attributes">
      <div class="card w-100">
        <div class="card-header" style="padding:12px 20px;">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a
                href="#active"
                class="nav-link active"
                data-toggle="tab"
                role="tab"
              >Atención a la derivación</a>
            </li>
            <li class="nav-item">
              <a href="#link" class="nav-link" data-toggle="tab" role="tab">Evaluación del producto</a>
            </li>
          </ul>
        </div>
        <div class="card-body tab-content">
          <div id="active" class="tab-pane active" role="tabpanel">
            <div class="row">
              <div class="col-7">
                <div v-for="comentario in tarea.relationships.comentarios" :key="comentario.id">
                  <div>
                    <label>Fecha</label>
                    <datetime :read-only="true" v-model="comentario.attributes.com_fecha" />
                  </div>
                  <div>
                    <label>Comentario</label>
                    <div v-html="comentario.attributes.com_texto" />
                  </div>
                  <hr />
                </div>
                <div>
                  <label>Fecha</label>
                  <datetime v-model="com_fecha" />
                </div>
                <div>
                  <label>Comentario</label>
                  <tinymce v-model="com_texto" plugins="table" height="10em" />
                </div>
                <button type="button" class="btn btn-primary" @click="comentar">Registrar</button>
              </div>
              <div class="col-5">
                <folder-viewer
                  :api="'/api/folder/tareas/' + tarea.id"
                  :candelete="true"
                  :canupload="true"
                  :target="'tareas/' + tarea.id"
                ></folder-viewer>
              </div>
            </div>
          </div>
          <div id="link" class="tab-pane" role="tabpanel"></div>
        </div>
      </div>
    </div>
  </panel>
</template>

<script>
import moment from "moment";
import {colores, iconos, colorPrioridades, prioridades} from "../ConstantesSeguimiento";

const apiBase = "/api/adm_tareas";

export default {
  path: "/Tarea/:id",
  methods: {
    comentar() {
      this.comentario.attributes.tar_id = this.tarea.id;
      this.comentario.attributes.com_fecha = this.com_fecha;
      this.comentario.attributes.com_texto = this.com_texto;
      this.comentario
        .postToAPI("/api/tarea/" + this.$route.params.id + "/comentarios")
        .then(() => {
          this.tarea.loadFromAPI();
          this.com_fecha = "";
          this.com_texto = "";
        });
    },
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
    tiempoDisponible(tarea) {
      return moment().to(moment(tarea.attributes.tar_fecha_derivacion).add(tarea.relationships.derivacion.attributes.dias_plazo, 'days'));
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
          "?include=tar_creador,derivacion,usuarios,comentarios"
      ),
      comentario: new ApiObject(
        "/api/tarea/" + this.$route.params.id + "/comentarios/create"
      ),
      com_fecha: "",
      com_texto: ""
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
