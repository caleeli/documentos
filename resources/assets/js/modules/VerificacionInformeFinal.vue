<template>
    <panel name="Verificacion Inf. Final" class="panel-primary">
        
        <button type="button" class="btn btn-success" @click="completar">Completar</button>
    </panel>
</template>

<script>
    export default {
        data() {
            return {
            };
        },
        methods: {
            completar() {
                Process.completeTask(this.$route.query);
            }
        }
    };
</script>
