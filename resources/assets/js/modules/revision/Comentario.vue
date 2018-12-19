<template>
    <panel name="Comentarios" class="panel-secondary">
        <div class="jdd-comments">
            <textarea class="form-control" v-model="comentario" ></textarea>
        </div>
        <div class="text-right">
            <button class="btn btn-sm btn-primary" type="button" @click="addComment">Comentar</button>
        </div>
        <div v-for="comentario in config.comentarios" class="jdd-comments">
            <textarea class="form-control" :class="comentario.color" v-model="comentario.texto" ></textarea>
            <button class="btn btn-sm btn-success" type="button" @click="setColor(comentario, 'success')"></button>
            <button class="btn btn-sm btn-warning" type="button" @click="setColor(comentario, 'warning')"></button>
            <button class="btn btn-sm btn-danger" type="button" @click="setColor(comentario, 'danger')"></button>
        </div>
    </panel>
</template>

<script>
    export default {
        props: {
            "data": Object,
            "config": Object,
        },
        data() {
            return {
                comentario: '',
            };
        },
        methods: {
            addComment() {
                this.config.comentarios.unshift({
                    texto: this.comentario,
                    color: ''
                });
                this.comentario = '';
            },
            setColor(comentario, color) {
                comentario.color = 'jdd-bg-' + color + '-25';
            }
        }
    }
</script>

<style lang="scss">
    @import  "../../../sass/components/variables";
    .jdd-comments {
        position: relative;
    }
    .jdd-comments textarea{
        padding-right: 2em;
    }
    .jdd-bg-success-25 {
        border-color: $brand-success;
        background-color:rgba($brand-success, .25);
    }
    .jdd-bg-warning-25 {
        border-color: $brand-warning;
        background-color:rgba($brand-warning, .25);
    }
    .jdd-bg-danger-25 {
        border-color: $brand-danger;
        background-color:rgba($brand-danger, .25);
    }
    .jdd-comments button{
        right: 0em;
        position: absolute;
        width: 1em;
        height: 1em;
    }
    .jdd-comments button:nth-child(2){
        top: 0em;
    }
    .jdd-comments button:nth-child(3){
        top: 1em;
    }
    .jdd-comments button:nth-child(4){
        top: 2em;
    }
</style>
