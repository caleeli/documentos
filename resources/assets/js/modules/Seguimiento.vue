<template>
  <panel name="Seguimiento" class="panel-primary">
    <div class="d-flex">
      <div class="form-group flex-grow-1">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Busqueda" v-model="search" v-on:keyup.13="buscarTarea" />
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
            :disabled="page == 1"
            @click="setPage(1)"
          >
            1
            <i class="fas fa-step-backward"></i>
          </button>
          <button
            class="btn btn-outline-secondary"
            :disabled="page<2"
            @click="setPage(Math.max(1,page-1))"
          >
            <i class="fas fa-long-arrow-alt-left"></i> Previo
          </button>
          <button
            v-for="p in pagesIndex" :key="`page-btn-${p}`"
            :class="page == p ? 'btn btn-secondary' : 'btn btn-outline-secondary'"
            :ref="page == p ? 'currentPage' : ''"
            @click="setPage(p)"
          >
            {{ p }}
          </button>
          <button class="btn btn-outline-secondary" @click="setPage(page+1)">
            Siguiente
            <i class="fas fa-long-arrow-alt-right"></i>
          </button>
          <button
            class="btn btn-outline-secondary"
            :disabled="page == meta.last_page"
            @click="setPage(meta.last_page)"
          >
            <i class="fas fa-step-forward"></i>
            {{ meta.last_page }}
          </button>
        </div>
        <center>
          Total registros: 
          <b>{{ meta.total }}</b>
        </center>
      </div>
    </div>
    <hr>
    <div v-show="!loading">
      <div class="row" v-for="(tareaI,id) in tareas" :key="id">
        <div class="col-md-5 col-xs-12">
          <table width="100%">
            <tr>
              <td class="project-status" width="35%">
                <small>Estado</small>
                <br />
                <span v-bind:class="classEstado(tareaI)">
                  <i v-bind:class="iconoEstado(tareaI)"></i>
                  <span
                    class="hidden-xs hidden-sm hidden-md"
                    v-html="format(tareaI.attributes.tar_estado)"
                  ></span>
                </span>
              </td>
              <td class="project-title" width="65%">
                <router-link :to="'/Tarea/' + tareaI.id">
                  <small class="block-with-text" v-html="format(tareaI.attributes.tar_codigo)"></small>
                  <small class="block-with-text" v-html="format(tareaI.attributes.tar_descripcion)"></small>
                </router-link>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-3 col-xs-5 project-user">
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
          <span v-if="tareaI.attributes.tar_estado=='Pendiente'" class="d-inline-block flex-grow-1">
            <small>Asignado</small>
            <br />
            <pie-svg :value="tiempoReloj(tareaI)"></pie-svg>
            {{ diasPasados(tareaI) }}
          </span>
          <span v-else class="d-inline-block flex-grow-1">
            <small>{{tareaI.attributes.tar_estado}}</small>
            <br />
            <datetime
              :read-only="true"
              v-model="tareaI.attributes.tar_fecha_fin"
            />
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
import fechasTarea from "../mixins/fechasTarea";
import {
  colores,
  iconos,
  colorPrioridades,
  prioridades
} from "../ConstantesSeguimiento";
import debounce from 'debounce';

const apiBase = "/api/adm_tareas";

const setPage = debounce((tareas, page) => {
  tareas.setPagingOptions(page, 7);
}, 500);

export default {
  path: "/Seguimiento",
  mixins: [ajaxFilter, fechasTarea],
  methods: {
    setPage(page) {
      if (page == this.page) {
        return;
      }
      this.loading = true;
      this.page = page;
      if (this.tareas.setPagingOptions instanceof Function) {
        setPage(this.tareas, page);
      }
      if (this.$refs.currentPage && this.$refs.currentPage.focus instanceof Function) {
        this.$refs.currentPage.focus();
      } else if (this.$refs.currentPage instanceof Array) {
        this.$refs.currentPage.forEach(cp => {
          if (cp.focus instanceof Function) {
            cp.focus();
          }
        })
      }
    },
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
      if (this.$route.query.estado) {
        this.updateFilter(this.tareas, this.search, this.filterBy, ['whereUserOwner','whereTarEstado,' + this.$route.query.estado]);
      } else {
        this.updateFilter(this.tareas, this.search, this.filterBy, ['whereUserAssigned']);
      }
    },
    avancePasosPorcentaje() {
      return 1;
    },
  },
  computed: {
    pagesIndex() {
      const min = Math.max(1, Math.min(this.page - 1, this.meta.last_page - 2));
      const max = Math.min(this.meta.last_page, min + 2);
      const res = [];
      for(let i = min; i <= max; i++) {
        res.push(i);
      }
      return res;
    },
  },
  data() {
    let url;
    if (this.$route.query.estado) {
      url = "/api/tarea?meta=pagination&filter[]=whereUserOwner&filter[]=whereTarEstado," + this.$route.query.estado + "&sort=-tar_prioridad,tar_id&per_page=7&include=usuarios";
    } else {
      url = "/api/tarea?meta=pagination&filter[]=whereUserAssigned&sort=-tar_prioridad,tar_id&per_page=7&include=usuarios";
    }
    const meta = {
      type: '',
      total: '',
      per_page: '',
      last_page: '',
      page: '',
    };
    return {
      loading: true,
      estado: "",
      tareas: new ApiArray(url, {}, meta),
      meta,
      page: 1,
      search: "",
      filterBy:
        "attributes.tar_codigo attributes.tar_estado attributes.tar_descripcion relationships.usuarios.attributes.nombres relationships.usuarios.attributes.apellidos"
    };
  },
  watch: {
    'meta.loading'(loading) {
      this.loading = loading;
    },
    '$route.query.estado': {
      immediate: true,
      handler() {
        this.estado = this.$route.query.estado || "";
        this.buscarTarea();
      }
    }
  },
  mounted() {
    this.tareas.loadFromAPI();
  }
};
</script>
