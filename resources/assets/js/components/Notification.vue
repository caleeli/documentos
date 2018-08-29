<template>
  <li class="nav-item dropdown">
    <a class="nav-link " data-toggle="dropdown" href="#">
      <i v-bind:class="icon"></i>
      <span class="badge notification-count" v-bind:class="countClass">4</span>
    </a>
    <vnode class="dropdown-menu" slot-from="default"/>
  </li>
</template>

<script>
  export default {
      props: {
          icon: String,
          countClass: String,
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
</style>
