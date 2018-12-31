<template>
    <div>
        ...
    </div>
</template>

<script>
    export default {
        path: "/Process/Complete/:id/:token",
        data() {
            return {
                links: [],
            };
        },
        mounted() {
            Process.completeTask(this.$route.params, this.$route.query).then(response => {
                this.$router.push({
                    path: '/Process/Open/' + response.data.instanceId,
                });
            });
        }
    };
</script>

<style lang="scss">
</style>
