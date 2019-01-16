<template>
    <div class="card primary-view dashboard-item" @click="click">
        <div class="card-header">
            <div class="card-photo">
                <img :title="value.text" :alt="value.text" :src="value.icon" class="img-circle">
            </div>
            <div class="card-short-description">
                <h5 class="dashboard-item-title">
                    <router-link v-if="value.href" :to="value.href">{{value.text}}</router-link>
                    <a v-else href="javascript:void(0)">{{value.text}}</a>
                </h5>
                <p class="dashboard-item-description">{{value.description}}&nbsp;</p>
            </div>
            <div v-if="$slots.default" class="action-dropdown dropdown">
                <a class="dropdown" data-toggle="dropdown" href="javascript:void(0)" aria-expanded="true">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" style="padding:0.5em">
                    <slot></slot>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: Object,
        },
        computed: {
            href() {
                return this.value.href ? this.value.href : 'javascript:void(0)';
            },
        },
        methods: {
            click(event) {
                const isDropdown = $(event.target).hasClass('dropdown') || $(event.target.parentNode).hasClass('dropdown');
                console.log(event.target, isDropdown);
                !isDropdown && this.value.href ? this.$router.push(this.value.href) : null;
            }
        },
    }
</script>

<style>
    .card-short-description{
        position: relative;
        margin-left: 76px;
    }
    .dashboard-item {
        cursor:pointer;
    }
    .dashboard-item .card-header:hover {
        background-color: rgb(25%, 31%, 71%, 0.05);
    }
    .dashboard-item-title {
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
    .dashboard-item-description {
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
    .action-dropdown {
        right: 8px;
        top: 40px;
        bottom: auto;
    }
    .primary-view .action-dropdown > a {
        background-color: transparent;
        border: 0 none;
    }
    .primary-view {
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        padding: 0;
        overflow: visible;
    }
</style>
