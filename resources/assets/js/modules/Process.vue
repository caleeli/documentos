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
            Process.tasks(this.$route.params).then(links => {
                this.links.splice(0);
                this.links.push(...links);
                if (links.length === 1) {
                    this.$router.push({
                        path: links[0].href,
                    });
                }
            });
        }
    };
</script>

<style lang="scss">
</style>
