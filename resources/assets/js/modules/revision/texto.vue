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
                if (typeof window.autoSave === 'string') {
                    window[window.autoSave]();
                }
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
                return this.$parent.editMode;
            }
        }
    }
</script>
