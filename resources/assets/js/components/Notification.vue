<template>
  <li class="nav-item dropdown">
    <a class="nav-link" v-bind:class="textClass" data-toggle="dropdown" href="#">
      <i v-bind:class="icon"></i>
      <span class="badge notification-count" v-bind:class="countClass" v-show="notifications.length">{{notifications.length}}</span>
    </a>
    <ul class="dropdown-menu notification">
      <li v-for="notificacion in notifications">
        <a v-bind:href="notificacion.href" class="dropdown-item">
          <div>
            <i v-bind:class="notificacion.icono"></i> {{notificacion.texto}}
            <span class="float-right text-muted small">{{moment(notificacion.created_at).fromNow()}}</span>
          </div>
        </a>
      </li>
    </ul>
  </li>
</template>

<script>
  export default {
      props: {
          icon: String,
          countClass: null,
          textClass: null,
          notifications: Array,
      },
      methods: {
      }
  }
</script>

<style>
  .notification-count {
      position: absolute;
      left: 50%;
      top: 0em;
      padding: 0.5em;
  }
  .notification {
      width: 345px;
      left: -300px;
  }
</style>
