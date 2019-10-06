<template>
  <panel name="Seguimiento" class="panel-primary">
    <div class="form-group">
      <div class="input-group">
        <span class="input-group-prepend">
          <a href="javascript:void(0)" class="input-group-text" v-on:click="listarTareas">
            <i class="fas fa-sync"></i>
            <small class="hidden-xs hidden-sm ml-1">Recargar</small>
          </a>
        </span>
        <input type="text" class="form-control" placeholder="Busqueda" v-model="busquedaTareas" />
        <span class="input-group-append">
          <a href="javascript:void(0)" class="input-group-text bg-success text-light" v-on:click="buscarTarea">
            <i class="fa fa-search"></i>
            <small class="hidden-xs hidden-sm ml-1">Buscar</small>
          </a>
        </span>
      </div>
    </div>
    <div>
      <div class="row" v-for="(tareaI,id) in tareas" :key="id">
        <div class="col-md-4 col-xs-12">
          <table width="100%">
            <tr>
              <td class="project-status" width="35%">
                <small>Estado</small>
                <br />
                <span v-bind:class="classEstado(tareaI)">
                  <i v-bind:class="iconoEstado(tareaI)"></i>
                  <span class="hidden-xs hidden-sm hidden-md">{{ tareaI.attributes.tar_estado }}</span>
                </span>
              </td>
              <td class="project-title" width="65%">
                <a href="#detalleTarea" v-on:click="seleccionaTarea(tareaI)">
                  {{tareaI.attributes.tar_codigo}}
                  <small
                    class="block-with-text"
                  >{{tareaI.attributes.tar_descripcion}}</small>
                </a>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-2 col-xs-4 project-completion">
          <div class="progress progress-striped active m-b-sm">
            <div
              v-bind:style="{width: tareaI.attributes.tar_avance +'%'}"
              class="progress-bar progress-bar-success"
            ></div>
          </div>
          <span class="badge badge-success">1</span>
          <span class="badge badge-light">2</span>
        </div>
        <div class="col-md-2 col-xs-5 project-user">
          <div v-for="(u,i) in usuariosAsignados(tareaI.relationships.usuarios)" :key="i">
            <img
              class="avatar1em"
              v-bind:src="u.attributes.fotografia ? u.attributes.fotografia.url : '/images/slightly-smiling-face_1f642.png'"
            />
            {{u.attributes.nombres+' '+u.attributes.apellidos}}
          </div>
        </div>
        <!-- td class="project-owner">
                                                                    <i class="fa fa-user-secret"></i> {{tareaI.relationships.creador.attributes.nombres+' '+tareaI.relationships.creador.attributes.apellidos}}
        </td-->
        <div class="col-md-1 col-xs-3 text-right project-priority">
          <span class="d-inline-block text-center">
            <small>Prioridad</small>
            <br />
            <span v-bind:class="classPriodidad(tareaI)">{{labelPrioridad(tareaI)}}</span>
          </span>
        </div>
        <div class="col-md-3 col-xs-12 project-actions text-right" style="padding-top: 0.5em">
          <span
            v-if="tareaI.attributes.dias_otorgados>=0"
            style="display: inline-block; float: left;"
          >
            <div>
              <peity
                v-bind:value="tareaI.attributes.dias_pasados"
                v-bind:total="tareaI.attributes.dias_otorgados"
              />
            </div>
            <small>{{tareaI.attributes.dias_otorgados ? Math.max(0, tareaI.attributes.dias_otorgados - tareaI.attributes.dias_pasados)+'d' : ''}}</small>
          </span>
          <!--
          <a
            v-if="esUsuarioGerente()"
            href="javascript:void(0)"
            class="btn btn-white btn-sm"
            v-on:click="cancelarTarea(tareaI)"
          >
            <i class="fa fa-times"></i> Cancelar
          </a>
          <a
            v-if="isOwnedByUser(tareaI)"
            href="#asignarTarea"
            class="btn btn-white btn-sm"
            v-on:click="modificarTarea(tareaI)"
          >
            <i class="fa fa-pencil"></i> Modificar
          </a>
          -->
          <a href="#detalleTarea" class="btn btn-white btn-sm" v-on:click="seleccionaTarea(tareaI)">
            <i class="fa fa-folder"></i> Abrir
          </a>
        </div>
        <div class="col-xs-12">
          <hr />
        </div>
      </div>
    </div>
  </panel>
</template>

<script>
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
  path: "/Seguimiento",
  methods: {
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
  computed: {},
  data() {
    return {
      tareas: new ApiArray("/api/tarea?sort=-tar_prioridad&per_page=7"),
      busquedaTareas: ""
    };
  },
  watch: {}
};
</script>
