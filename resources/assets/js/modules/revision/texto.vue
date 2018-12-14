<template type='text/x-template' id='texto'>
    <div class="editable" >
        <span v-html="innerValue ? innerValue.split('\n').join('<br>') : ''"></span>
        <textarea v-model="innerValue" v-if="editable()"></textarea>
    </div>
</template>

<script>
    export default {
        template: '#texto',
        props: {
            "value": String
        },
        watch: {
            'value': function(value) {
                this.innerValue = value;
            },
            'innerValue': function(value) {
                this.$emit('input', value);
            }
        },
        data: function() {
            return {
                innerValue: this.value
            };
        },
        methods: {
            editable: function() {
                return true;//this.$parent.editMode;
            }
        }
    }
</script>

<style lang="scss">
    div.editable {
        position: relative;
        width: 100%;
        border: 1px lightgreen dashed;
        min-height: 0.9em;
    }
    div.editable textarea {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        border: none;
        resize: none;
        padding: 0px;
        margin: 0px;
    }
</style>
