<template>
    <select class="token" size="1" multiple="" :name="jsonConfig"><option>{{data[config.name]}}</option></select>
</template>

<script>
    export default {
        props: {
            "data": Object,
            "config": Object,
        },
        computed: {
            jsonConfig() {
                return this.config ? JSON.stringify(this.config) : '{}';
            }
        },
    }
</script>

<style lang="scss">
</style>
