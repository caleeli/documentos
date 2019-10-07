<template>
  <svg viewBox="0 0 64 64" class="pie-svg">
    <circle r="25%" cx="50%" cy="50%" :style="progress" />
  </svg>
</template>

<script>
export default {
  props: {
    value: Number,
    background: {
      default: "#299050"
    },
    color: {
      default: "#db2c2c"
    }
  },
  computed: {
    progress() {
      return `stroke-dasharray: ${this.value} 99; stroke: ${this.color};`;
    }
  }
};
</script>

<style>
.pie-svg {
  width: 1em;
  border-radius: 50%;
  transform: rotate(-90deg);
}

.pie-svg circle {
  fill: none;
  stroke-width: 32;
}
</style>