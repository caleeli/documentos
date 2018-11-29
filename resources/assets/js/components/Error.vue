<template>
    <span>
        <div v-if="property==='message' && value.message" class="alert alert-danger">
            {{value.message}}
        </div>
        <small v-else class="badge badge-danger" v-for="error in errors">
            {{error}}
        </small>
    </span>
</template>

<script>
    export default {
        props: {
            value: Object,
            property: String,
        },
        computed: {
            errors() {
                const errors = _.get(this.value, this.property);
                return errors ? (errors instanceof Array ? errors : [errors]) : [];
            }
        }
    }
</script>
