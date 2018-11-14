<template>
    <span class="jdd-avatar-circle">
        <i v-if="!src" class="fa fa-user jdd-avatar-circle-image"></i>
        <img v-if="src" v-bind:src="src" class="jdd-avatar-circle-image"/>
    </span>
</template>
<script>

    export default {
        props: {
            value: Object,
            field: String
        },
        data() {
            return {
                fieldName: this.field ? this.field : 'avatar',
            };
        },
        computed: {
            avatar () {
                return this.value && this.value.attributes && this.value.attributes[this.fieldName]
                        ? this.value.attributes[this.fieldName] : (this.value ? this.value : {url: ""});
            },
            src() {
                return this.avatar.url ? this.avatar.url : '';
            }
        },
        mounted() {
        }
    }
</script>
<style lang="scss">
    .jdd-avatar-circle {
        width: 1em;
        height: 1em;
        display: inline-block;
        border-radius: 50%;
        background: white;
        overflow: hidden;
        position: relative;
    }
    .jdd-avatar-circle .jdd-avatar-circle-image{
        width: 100%;
        height: 100%;
        position: absolute;
    }
</style>
