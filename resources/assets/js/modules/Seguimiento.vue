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
          <a
            href="javascript:void(0)"
            class="input-group-text bg-success text-light"
            v-on:click="buscarTarea"
          >
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
                <router-link :to="'/Tarea/' + tareaI.id">
                  {{tareaI.attributes.tar_codigo}}
                  <small
                    class="block-with-text"
                  >{{tareaI.attributes.tar_descripcion}}</small>
                </router-link>
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
          <div v-for="(u,i) in tareaI.relationships.usuarios" :key="i">
            <avatar :user="u" />
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
        <div class="col-md-3 col-xs-12 project-actions text-left" style="padding-top: 0.5em">
          <span class="d-inline-block">
            <pie-svg :value="tiempoReloj(tareaI)"></pie-svg>
            {{ diasPasados(tareaI) }}
          </span>
          <span class="d-inline-block">
            <router-link :to="'/Tarea/' + tareaI.id" class="btn btn-primary btn-sm">
              <i class="fa fa-folder"></i> Abrir
            </router-link>
          </span>
        </div>
        <div class="col-12">
          <hr />
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
  path: "/Seguimiento",
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
  computed: {},
  data() {
    return {
      tareas: new ApiArray(
        "/api/tarea?sort=-tar_prioridad&per_page=7&include=derivacion,usuarios"
      ),
      busquedaTareas: ""
    };
  },
  watch: {}
};
</script>
