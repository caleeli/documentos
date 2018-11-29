<template>
    <span>
        <small class="badge badge-danger" v-for="error in value">
            {{error}}
        </small>
    </span>
</template>

<script>
    export default {
        props: {
            value: Array
        }
    }
</script>
