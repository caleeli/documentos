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
            <span
              class="badge"
              :class="{'badge-warning': tarea.attributes.tar_estado == 'Pendiente',
                'badge-primary': tarea.attributes.tar_estado == 'Completado',
                'badge-success': tarea.attributes.tar_estado == 'Aprobado'}"
            >{{tarea.attributes.tar_estado}}</span>
            <button
              class="btn-sm btn-bajo" :class="{'btn-success':!pendientesCalificacion, 'btn-secondary':pendientesCalificacion}"
              v-if="tarea.attributes.tar_estado == 'Completado' && esRolUno"
              type="button"
              :disabled="pendientesCalificacion > 0"
              @click="aprobarTarea"
            >
              <i class="fa fa-check-square"></i> Aprobar
            </button>
            {{ pendientesCalificacion ? `${pendientesCalificacion} pendiente${pendientesCalificacion>1?'s':''} de calificación` : ''}}
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
              <span>
                <avatar :user="usuario" />
                {{usuario ? usuario.attributes.nombre_completo : ''}}
              </span>
              <span v-if="!editable && calificando === usuario">
                <input
                  type="number"
                  placeholder="calificación"
                  aria-label="calificación"
                  v-model="usuario.attributes.pivot.calificacion"
                  max="100"
                  min="0"
                />
                <a v-if="esRolUno" href="javascript:void(0)" @click="calificar(usuario)">
                  <i class="fas fa-save"></i>
                </a>
              </span>
              <span v-else-if="!editable && esRolUno" style="width: 50%;">
                <span
                  class="badge" :class="{'badge-info': usuario.attributes.pivot.calificacion, 'badge-warning': !usuario.attributes.pivot.calificacion}"
                >Calificación: {{ usuario.attributes.pivot.calificacion || '?' }}</span>
                <a href="javascript:void(0)" @click="editarCalificacion(usuario)">
                  <i class="fas fa-pen"></i>
                </a>
              </span>
              <span v-if="editable && !usuario.attributes.pivot.fecha_conclusion">
                <pie-svg :value="tiempoRelojUsuario(tarea, usuario)"></pie-svg>
                {{ tiempoDisponibleUsuario(tarea, usuario) }}
                <a
                  class="btn-sm btn-success d-inline-block"
                  v-if="esRolUno"
                  href="javascript:void(0)"
                  @click="completarTarea(usuario.id)"
                >
                  <i class="fa fa-check"></i> Completar
                </a>
              </span>
              <span v-if="editable && usuario.attributes.pivot.fecha_conclusion">
                <i class="fas fa-check-square text-success"></i>
                <datetime :read-only="true" v-model="usuario.attributes.pivot.fecha_conclusion" />
              </span>
            </div>
          </dd>
        </dl>
      </div>
      <div class="col-lg-7" id="cluster_info">
        <dl class="dl-horizontal">
          <dt>Fecha de Derivación:</dt>
          <dd>
            <datetime :read-only="true" v-model="tarea.attributes.fecha_registro" />
          </dd>
          <dt>Última actualización:</dt>
          <dd>
            <datetime :read-only="true" v-model="tarea.attributes.fecha_modificacion" />
          </dd>
          <dt v-if="tarea.attributes.tar_estado == 'Pendiente'">Tiempo asignado:</dt>
          <dd
            v-if="tarea.attributes.tar_estado == 'Pendiente'"
          >{{ maxDiasPlazo(tarea) }}, {{ diasPasados(tarea) }}</dd>
          <dt v-if="tarea.attributes.tar_estado == 'Pendiente'">Tiempo cumplimiento:</dt>
          <dd v-if="tarea.attributes.tar_estado == 'Pendiente'">
            <pie-svg :value="tiempoReloj(tarea)"></pie-svg>
            {{ maxDiasPlazo(tarea) }} días hábiles
          </dd>
          <dt v-if="tarea.attributes.tar_estado != 'Pendiente'">Completado:</dt>
          <dd v-if="tarea.attributes.tar_estado != 'Pendiente'">
            <datetime :read-only="true" v-model="tarea.attributes.tar_fecha_fin" />
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
                href="#atencion"
                class="nav-link active"
                data-toggle="tab"
                role="tab"
                @click="tab='atencion'"
              >Atención a la derivación</a>
            </li>
          </ul>
        </div>
        <div class="card-body tab-content">
          <div id="atencion" class="tab-pane active" role="tabpanel">
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
                  <atendido-recibido
                    :editable="editable"
                    v-model="tarea.attributes.tar_recibidos"
                    @input="actualizarRecibidos"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div>
                  <label>Atendidos</label>
                  <atendido-recibido
                    :editable="editable"
                    v-model="tarea.attributes.tar_atendidos"
                    @input="actualizarAtendidos"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <hr />
                <div v-for="(comentario,index) in comentarios" :key="comentario.id">
                  <div class="d-flex border-bottom mb-2" v-if="comentario.attributes">
                    <div>
                      <h2>
                        <avatar v-model="comentario.attributes.usuario"></avatar>
                      </h2>
                    </div>
                    <div>
                      <div class="text-sm">
                        <b>{{comentario.attributes.nombre_usuario}}</b>
                        <datetime
                          :read-only="true"
                          :timeago="true"
                          v-model="comentario.attributes.fecha_modificacion"
                        />
                        <label>comentó:</label>
                      </div>
                      <div class="d-flex">
                        <a
                          v-if="comentario.attributes.user_add == userId && comentarioEditado == -1"
                          href="javascript:void(0)"
                          @click="editComentario(index)"
                        >
                          <i class="fa fa-pen"></i>
                        </a>
                        <a
                          v-else-if="comentario.attributes.user_add == userId && comentarioEditado == index"
                          href="javascript:void(0)"
                          @click="actualizaComentario(comentario)"
                        >
                          <i class="fa fa-save"></i>
                        </a>
                        <a v-else href="javascript:void(0)">
                          <i class="fa fa-align-justify"></i>
                        </a>
                        <div v-if="comentarioEditado == index" class="pl-2">
                          <tinymce
                            v-model="comentario.attributes.com_texto"
                            plugins="table"
                            height="10em"
                          />
                        </div>
                        <div v-else class="ml-2" v-html="comentario.attributes.com_texto" />
                      </div>
                    </div>
                  </div>
                </div>
                <div v-show="comentarioEditado==-1">
                  <label>Comentario</label>
                  <tinymce v-model="com_texto" plugins="table" height="10em" />
                </div>
                <div v-show="comentarioEditado==-1">
                  <br />
                  <button type="button" class="btn btn-primary" @click="comentar">Registrar</button>
                  <button
                    v-if="editable && participa"
                    type="button"
                    class="btn btn-success"
                    @click="completarTarea(userId)"
                  >
                    <i class="fa fa-check-square"></i> Completar
                  </button>
                </div>
              </div>
              <div div class="col-12 ml-3">
                <folder-viewer
                  :api="'/api/folder/tareas/' + tarea.id"
                  :candelete="editable"
                  :canupload="editable"
                  :target="'tareas/' + tarea.id"
                ></folder-viewer>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </panel>
</template>

<script>
import moment from "../moment";
import fechasTarea from "../mixins/fechasTarea";
import {
  colores,
  iconos,
  colorPrioridades,
  prioridades
} from "../ConstantesSeguimiento";

const apiBase = "/api/adm_tareas";
const Pendiente = "Pendiente";
const Completado = "Completado";
const Aprobado = "Aprobado";

export default {
  path: "/Tarea/:id",
  mixins: [fechasTarea],
  methods: {

    aprobarTarea() {
      this.tarea.attributes.tar_estado = Aprobado;
      this.saveTarea().then(() => {
        this.tarea.callMethod('contarPendientes', {}).then(response => {
          this.$root.pendientesAprobar = response.data.response;
        });
        this.$router.push({ path: "/Seguimiento", query: { estado: 'Completado' } });
      });
    },
    editarCalificacion(usuario) {
      this.calificando = usuario;
    },
    calificar(usuario) {
      this.tarea
        .callMethod("calificar", {
          userId: usuario.id,
          calificacion: usuario.attributes.pivot.calificacion
        })
        .then(() => {
          this.tarea.loadFromAPI();
          this.calificando = null;
        });
    },
    actualizaComentario(comentario) {
      this.comentario.attributes.tar_id = this.tarea.id;
      this.comentario.attributes.com_texto = comentario.attributes.com_texto;
      this.comentario
        .putToAPI(
          "/api/tarea/" +
            this.$route.params.id +
            "/comentarios/" +
            comentario.id
        )
        .then(() => {
          this.tarea.loadFromAPI();
          this.comentarios.loadFromAPI();
          this.comentarioEditado = -1;
        });
    },
    editComentario(index) {
      this.comentarioEditado = index;
    },
    actualizarRecibidos() {
      this.saveTarea();
    },
    actualizarAtendidos() {
      this.saveTarea();
    },
    completarTarea(userId) {
      this.tarea.callMethod("completarTarea", { user: userId }).then(() => {
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
      this.comentario.attributes.com_texto = this.com_texto;
      this.comentario
        .postToAPI("/api/tarea/" + this.$route.params.id + "/comentarios")
        .then(() => {
          this.tarea.loadFromAPI();
          this.comentarios.loadFromAPI();
          this.com_texto = "";
        });
    },
    seleccionaTarea() {},
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
    pendientesCalificacion() {
      let pendientes = 0;
      this.tarea.relationships.usuarios.forEach(usuario => {
        if (usuario.id != this.tarea.relationships.tar_creador.id) {
          pendientes += usuario.attributes.pivot.calificacion ? 0 : 1;
        }
      });
      return pendientes;
    },
    participa() {
      let participa = false;
      this.tarea.relationships.usuarios.forEach(user => {
        participa = participa || user.id == this.$root.user.id;
      });
      return participa;
    },
    userId() {
      return window.userId;
    },
    esRolUno() {
      return this.$root.user.attributes.role_id == 1;
    },
    editable() {
      return this.tarea.attributes.tar_estado === Pendiente;
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
      calificando: null,
      tarea: new ApiObject(
        "/api/tarea/" +
          this.$route.params.id +
          "?include=tar_creador,derivacion,usuarios"
      ),
      comentarios: new ApiObject(
        "/api/tarea/" + this.$route.params.id + "/comentarios?sort=com_id"
      ),
      comentario: new ApiObject(
        "/api/tarea/" + this.$route.params.id + "/comentarios/create"
      ),
      com_texto: "",
      prioridades,
      editPrioridad: false,
      tab: "atencion",
      comentarioEditado: -1
    };
  },
  mounted() {
    this.tarea.loadFromAPI();
    this.comentarios.loadFromAPI();
  },
  watch: {
    "tarea.attributes": {
      deep: true,
      handler() {
        this.tab =
          this.tarea.attributes.tar_estado === Completado
            ? "evaluacion"
            : "atencion";
        const avance = Math.max(
          0,
          Math.min(100, this.tarea.attributes.tar_avance)
        );
        avance != this.tarea.attributes.tar_avance
          ? (this.tarea.attributes.tar_avance = avance)
          : null;
        const calificacion = Math.max(
          0,
          Math.min(100, this.tarea.attributes.tar_calificacion)
        );
        calificacion != this.tarea.attributes.tar_calificacion
          ? (this.tarea.attributes.tar_calificacion = calificacion)
          : null;
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
  width: 69%;
  text-align: left;
  vertical-align: text-top;
}
.nav-link.disabled {
  opacity: 0.5;
}
.btn-bajo {
  padding: 0px 12px;
}
</style>
