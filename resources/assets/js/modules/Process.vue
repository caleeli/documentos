<template>
    <desktop :links="links">
    </desktop>
</template>

<script>
    export default {
        path: "/Process/:id",
        data() {
            return {
                links: [],
            };
        },
        mounted() {
            Process.tasks(this.$route.params).then(response => {
                this.links.splice(0);
                this.links.push(...response.data);
                if (this.links.length === 1) {
                    this.$router.push({
                        path: this.links[0].href,
                    });
                }
            });
        }
    };
</script>

<style lang="scss">
</style>
