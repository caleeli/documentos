<template>
    <span>
        ...
    </span>
</template>

<script>
    export default {
        path: "/ProcessStart/:process/:event",
        mounted() {
            Process.start(this.$route.params).then(instance => {
                this.$router.push({
                    path: '/Process/' + instance.data.instanceId,
                });
            });
        }
    };
</script>

<style lang="scss">
</style>
