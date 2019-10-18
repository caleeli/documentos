<template>
  <panel :name="titulo" class="panel-primary">
    <template slot="actions">
      <router-link class="btn btn-info btn-sm" :to="{path:'/Seguimiento'}">
        <i class="fas fa-arrow-circle-left"></i> Volver
      </router-link>
    </template>
    <div class="row" v-if="tarea.attributes">
      <div class="col-lg-5">
        <dl class="dl-horizontal">
          <dt>Estado:</dt>
          <dd>
            <span class="badge badge-primary">{{tarea.attributes.tar_estado}}</span>
          </dd>
          <div style="height: 4px;"></div>
          <dt>Prioridad:</dt>
          <dd v-if="!editPrioridad || !editable">
            <span v-bind:class="classPriodidad(tarea)">{{labelPrioridad(tarea)}}</span>
            <a v-if="editable && esRolUno" href="javascript:void(0)" @click="openPrioridad">
              <i class="fa fa-pen"></i>
            </a>
          </dd>
          <dd v-if="editable && editPrioridad">
            <select v-model="tarea.attributes.tar_prioridad">
              <option v-for="(prioridad,key) in prioridades" :value="key" :key="key">{{prioridad}}</option>
            </select>
            <a href="javascript:void(0)" @click="savePrioridad">
              <i class="fa fa-save"></i>
            </a>
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
          <dt>Fecha de Derivación:</dt>
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
          <dt>Calificación:</dt>
          <dd>{{tarea.attributes.tar_calificacion}}</dd>
        </dl>
      </div>
    </div>
    <div class="row" v-if="tarea.attributes">
      <div class="card w-100">
        <div class="card-header" style="padding:12px 20px;">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a
                href="#atencion"
                class="nav-link"
                :class="tabAtencion"
                data-toggle="tab"
                role="tab"
                @click="tab='atencion'"
              >Atención a la derivación</a>
            </li>
            <li class="nav-item">
              <a
                href="#evaluacion"
                class="nav-link"
                :class="tabEvaluacion"
                data-toggle="tab"
                role="tab"
                @click="tarea.attributes.tar_estado==='Completado' ? tab='evaluacion' : null"
              >Evaluación del producto</a>
            </li>
          </ul>
        </div>
        <div class="card-body tab-content">
          <div id="atencion" class="tab-pane" :class="{active: tab === 'atencion'}" role="tabpanel">
            <!-- Ocultado con el ticket #43 -->
            <div class="row" v-show="false">
              <div class="col-3">
                <div>
                  <label>% de Avance</label>
                  <div class="input-group mb-3">
                    <input
                      v-model="tarea.attributes.tar_avance"
                      type="number"
                      class="form-control"
                      :readonly="!editable"
                      min="0"
                      max="100"
                      placeholder="%"
                    />
                    <div class="input-group-append" v-if="editable">
                      <a
                        href="javascript:void(0)"
                        class="input-group-text bg-success text-white"
                        @click="saveTarea"
                      >
                        <i class="fas fa-save"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div>
                  <label>Recibidos</label>
                  <atendido-recibido :editable="editable" v-model="tarea.attributes.tar_recibidos" @input="actualizarRecibidos" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div>
                  <label>Atendidos</label>
                  <atendido-recibido :editable="editable" v-model="tarea.attributes.tar_atendidos" @input="actualizarAtendidos" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <hr />
                <div v-for="comentario in tarea.relationships.comentarios" :key="comentario.id">
                  <div>
                    <label>Fecha</label>
                    <datetime :read-only="true" v-model="comentario.attributes.com_fecha" />
                  </div>
                  <div>
                    <avatar v-model="comentario.attributes.user_add"></avatar>
                    <b>{{comentario.attributes.nombre_usuario}}</b>
                    <label>comentó:</label>
                    <div v-html="comentario.attributes.com_texto" />
                  </div>
                  <hr />
                </div>
                <div v-if="editable">
                  <label>Fecha</label>
                  <datetime v-model="com_fecha" />
                </div>
                <div v-if="editable">
                  <label>Comentario</label>
                  <tinymce v-model="com_texto" plugins="table" height="10em" />
                </div>
                <div v-if="editable">
                  <br />
                  <button type="button" class="btn btn-primary" @click="comentar">Registrar</button>
                  <button type="button" class="btn btn-success" @click="completarTarea">
                    <i class="fa fa-check-square"></i> Completado
                  </button>
                </div>
              </div>
              <!-- <div div class="col-5">
                <folder-viewer
                  :api="'/api/folder/tareas/' + tarea.id"
                  :candelete="editable"
                  :canupload="editable"
                  :target="'tareas/' + tarea.id"
                ></folder-viewer>
              </div> !-->
            </div>
          </div>
          <div
            id="evaluacion"
            class="tab-pane"
            :class="{active: tab === 'evaluacion'}"
            role="tabpanel"
          >
            <div>
              <label>Calificación</label>
              <input class="form-control" v-model="tarea.attributes.tar_calificacion" type="number" min="0" max="100" />
            </div>
            <hr />
            <div>
              <button type="button" class="btn btn-primary" @click="saveExitTarea">
                <i class="fas fa-save"></i> Guardar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </panel>
</template>

<script>
import moment from "moment";
import {
  colores,
  iconos,
  colorPrioridades,
  prioridades
} from "../ConstantesSeguimiento";

const apiBase = "/api/adm_tareas";
const Completado = "Completado";

export default {
  path: "/Tarea/:id",
  methods: {
    actualizarRecibidos() {
      this.saveTarea();
    },
    actualizarAtendidos() {
      this.saveTarea();
    },
    completarTarea() {
      this.tarea.attributes.tar_fecha_fin = moment().format(
        "YYYY-MM-DD HH:mm:ss"
      );
      this.tarea.attributes.tar_estado = Completado;
      this.saveTarea().then(() => {
        this.comentar();
        this.$router.push({ path: "/Seguimiento" });
      });
    },
    openPrioridad() {
      this.editPrioridad = true;
    },
    savePrioridad() {
      this.editPrioridad = false;
      this.saveTarea();
    },
    saveExitTarea() {
      this.tarea.putToAPI("/api/tarea/" + this.$route.params.id).then(() => {
        this.$router.push({ path: "/Seguimiento" });
      });
    },
    saveTarea() {
      return this.tarea.putToAPI("/api/tarea/" + this.$route.params.id);
    },
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
      return moment().to(
        moment(tarea.attributes.tar_fecha_derivacion).add(
          tarea.relationships.derivacion.attributes.dias_plazo,
          "days"
        )
      );
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
    esRolUno() {
      return this.$root.user.attributes.role_id == 1;
    },
    editable() {
      return this.tarea.attributes.tar_estado !== Completado;
    },
    tabEvaluacion() {
      return (
        (this.tarea.attributes.tar_estado === Completado ? "" : "disabled") +
        (this.tab === "evaluacion" ? " active" : "")
      );
    },
    tabAtencion() {
      return this.tab === "atencion" ? " active" : "";
    },
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
      com_texto: "",
      prioridades,
      editPrioridad: false,
      tab: "atencion"
    };
  },
  mounted() {
    this.tarea.loadFromAPI();
  },
  watch: {
    "tarea.attributes": {
      deep: true,
      handler() {
        this.tab =
          this.tarea.attributes.tar_estado === Completado
            ? "evaluacion"
            : "atencion";
        const avance = Math.max(0, Math.min(100, this.tarea.attributes.tar_avance));
        avance != this.tarea.attributes.tar_avance ? this.tarea.attributes.tar_avance = avance : null;
        const calificacion = Math.max(0, Math.min(100, this.tarea.attributes.tar_calificacion));
        calificacion != this.tarea.attributes.tar_calificacion ? this.tarea.attributes.tar_calificacion = calificacion : null;
      }
    }
  }
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
.nav-link.disabled {
  opacity: 0.5;
}
</style>
