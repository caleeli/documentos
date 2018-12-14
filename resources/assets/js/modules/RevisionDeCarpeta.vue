<template>
    <panel name="Revision de carpeta Inf. preliminar" class="panel-primary">
        
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
