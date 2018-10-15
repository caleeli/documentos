<template>
  <div v-bind:class="displayClass">
    <div>
      <span v-bind:class="icon" v-bind:style="{color:color}"></span>
      <a class="jdd-document-text" v-bind:href="href" target="_blank">{{value.name}}</a>
    </div>
    <div>
      <small>Creado el <date-time class="jdd-document-date" v-model="value.updated_at" /></small>
    </div>
  </div>
</template>
<script>

  export default {
      props: {
          value: Object,
          format: String
      },
      data() {
          return {
              icon: '',
              color: '',
              type: ''
          };
      },
      watch: {
          value: {
              handler() {
                  var color, icon, type;
                  switch (this.value.mime) {
                      case 'application/pdf':
                          icon = 'fa fa-file-pdf';
                          color = 'rgb(226, 31, 52)';
                          type = 'pdf';
                          break;
                      case 'application/msword':
                      case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                      case 'application/vnd.openxmlformats-officedocument.wordprocessingml.template':
                      case 'application/vnd.ms-word.document.macroEnabled.12':
                      case 'application/vnd.ms-word.template.macroEnabled.12':
                          icon = 'fa fa-file-word';
                          color = '#2372BA';
                          type = 'word';
                          break;
                      case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
                      case 'application/vnd.ms-excel':
                      default:
                          type = 'excel';
                          icon = 'fa fa-file-excel';
                          color = 'rgb(0, 177, 15)';
                  }
                  this.icon = icon;
                  this.color = color;
                  this.type = type;
              },
              deep: true
          }
      },
      computed: {
          href() {
            return this.value.href ? this.value.href : 'javascript:void(0)';
          },
          displayClass() {
            return 'jdd-document-list-view';
          }
      },
      mounted() {
      }
  }
</script>