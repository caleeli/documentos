<template>
  <panel name="Seguimiento" class="panel-primary">
    <div class="d-flex">
      <div class="form-group flex-grow-1">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Busqueda" v-model="search" />
          <span class="input-group-append">
            <a
              href="javascript:void(0)"
              class="input-group-text bg-light text-primary"
              v-on:click="buscarTarea"
            >
              <i class="fa fa-search"></i>
              <small class="hidden-xs hidden-sm ml-1">BUSCAR</small>
            </a>
          </span>
        </div>
      </div>
      <div>
        <div class="btn-group ml-4">
          <button
            class="btn btn-outline-secondary"
            :disabled="page<2"
            @click="page=Math.max(1,page-1)"
          >
            <i class="fas fa-long-arrow-alt-left"></i> Previo
          </button>
          <button class="btn btn-outline-secondary" @click="page=page+1">
            Siguiente
            <i class="fas fa-long-arrow-alt-right"></i>
          </button>
        </div>
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
                  <span class="hidden-xs hidden-sm hidden-md" v-html="format(tareaI.attributes.tar_estado)"></span>
                </span>
              </td>
              <td class="project-title" width="65%">
                <router-link :to="'/Tarea/' + tareaI.id">
                  <small class="block-with-text" v-html="format(tareaI.attributes.tar_codigo)"></small>
                  <small
                    class="block-with-text"
                    v-html="format(tareaI.attributes.tar_descripcion)"
                  ></small>
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
          <span class="badge badge-light">{{tareaI.attributes.tar_avance}} %</span>
        </div>
        <div class="col-md-2 col-xs-5 project-user">
          <div v-for="(u,i) in tareaI.relationships.usuarios" :key="i">
            <avatar :user="u" />
            <span v-html="format(u.attributes.nombres+' '+u.attributes.apellidos)"></span>
          </div>
        </div>
        <div class="col-md-1 col-xs-3 text-right project-priority">
          <span class="d-inline-block text-center">
            <small>Prioridad</small>
            <br />
            <span v-bind:class="classPriodidad(tareaI)">{{labelPrioridad(tareaI)}}</span>
          </span>
        </div>
        <div class="col-md-3 col-xs-12 project-actions text-left d-flex">
          <span class="d-inline-block flex-grow-1">
            <small>Asignado</small>
            <br />
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
import ajaxFilter from "../mixins/ajaxFilter";
import {
  colores,
  iconos,
  colorPrioridades,
  prioridades
} from "../ConstantesSeguimiento";

const apiBase = "/api/adm_tareas";

export default {
  path: "/Seguimiento",
  mixins: [ajaxFilter],
  methods: {
    textValue(value) {
      return $("<i></i>")
        .html(value)
        .text();
    },
    format(input) {
      let value = this.textValue(input);
      if (!this.search) {
        return value;
      }
      let text = this.search;
      let length = text.length;
      let res = "";
      let u = -1;
      let i;
      while (
        (i = value
          .toLowerCase()
          .localeIndexOf(text, "en", { sensitivity: "base" })) > -1
      ) {
        res += value.substr(0, i);
        res += "<code>";
        res += value.substr(i, length);
        res += "</code>";
        u = i + length;
        value = value.substr(u);
      }
      res += value;
      return res;
    },
    seleccionaTarea() {},
    tiempoReloj(tarea) {
      const start = moment(tarea.attributes.tar_fecha_derivacion);
      const end = start.addWorkdays(
        tarea.relationships.derivacion.attributes.dias_plazo
      );
      return Math.min(
        100,
        Math.round(-100 * moment().diff(start) / start.diff(end))
      );
    },
    diasPasados(tarea) {
      const dias = moment().getBusinessDays(moment(tarea.attributes.tar_fecha_derivacion));
      return (
        (dias >= 0 ? "en " : "hace ") +
        Math.abs(dias) +
        (dias == 1 ? " día hábil" : " días hábiles")
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
    buscarTarea() {
      this.updateFilter(this.tareas, this.search, this.filterBy);
    },
    avancePasosPorcentaje() {
      return 1;
    }
  },
  computed: {},
  data() {
    return {
      tareas: new ApiArray(
        "/api/tarea?filter[]=whereUserAssigned&sort=-tar_prioridad,tar_id&per_page=7&include=derivacion,usuarios"
      ),
      page: 1,
      search: "",
      filterBy:
        "attributes.tar_codigo attributes.tar_estado attributes.tar_descripcion relationships.usuarios.attributes.nombres relationships.usuarios.attributes.apellidos"
    };
  },
  watch: {
    page(page) {
      if (this.tareas.setPagingOptions instanceof Function) {
        this.tareas.setPagingOptions(page, 7);
      }
    }
  },
  mounted() {
    this.tareas.loadFromAPI();
  }
};
</script>
