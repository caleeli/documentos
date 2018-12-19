<template>
    <panel name="Propiedades" class="panel-secondary">
        <div v-show="config.type">
            <div class="form-group">
                <label>Tipo</label>
                <select v-model="config.type" class="form-control">
                    <option value=""></option>
                    <option value="text">Texto</option>
                    <option value="select">Lista de selección</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nombre</label>
                <input v-model="config.name" class="form-control" placeholder="nombre">
            </div>
            <div class="form-group">
                <label>Datos</label>
                <input v-model="config.data" class="form-control" placeholder="origen de datos">
            </div>
            <div class="form-group">
                <label>Valor</label>
                <input v-model="data[config.name]" class="form-control" placeholder="valor actual">
            </div>
        </div>
    </panel>
</template>

<script>
    export default {
        props: {
            "data": Object,
            "config": Object,
        },
    }
</script>

<style lang="scss">
</style>
