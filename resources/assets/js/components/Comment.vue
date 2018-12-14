<template>
    <div class="jdd-comment">
        <div class="jdd-comment-header">
            <div class="jdd-comment-actions float-right">
                <slot></slot>
            </div>
            <button v-for="comment in value" 
                    class="btn btn-outline-secondary btn-sm jdd-comment-header-text"
                    @click="openComment(comment)">{{comment.header}}</button>
            <div class="jdd-comment-body">
                {{value[0].body}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: Array,
        },
        computed: {
        },
        methods: {
            openComment() {
                this.$emit('open-comment');
            }
        },
    }
</script>

<style lang="scss">
    .jdd-comment{
        border-color: rgb(192, 211, 235);
        background-color: rgb(255, 255, 255);
        position: relative;
        border-width: 1px;
        border-style: solid;
        border-image: initial;
        border-radius: 3px;
        height: 100%;
        /* flexbox setup */
        display: -webkit-flex;
        -webkit-flex-direction: row;

        display: flex;
        flex-direction: row;
    }
    .jdd-comment-header{
        background-color: rgb(241, 248, 255);
        border-bottom-color: rgb(192, 211, 235);
    }
    .jdd-comment-header-text{
        height: 2em;
        border-bottom: none;
        border-radius: 4px 4px 0px 0px;
        margin-bottom: 0px;
        border-color: rgb(192, 211, 235);
    }
    .jdd-comment-body {
        border: 1px solid rgb(192, 211, 235);
        background-color: white;
        padding: 0.5em;
    }
    .jdd-comment > *
    {
        -webkit-flex: 1 1 auto;
        flex: 1 1 auto;

        width: 30px; /* To make the transition work nicely.  (Transitions to/from
                        "width:auto" are buggy in Gecko and Webkit, at least.
                        See http://bugzil.la/731886 for more info.) */

        -webkit-transition: width 0.7s ease-out;
        transition: width 0.7s ease-out;
    }

    /* colors */
    .jdd-comment > div:nth-child(1){ background : #009246; }
    .jdd-comment > div:nth-child(2){ background : #F1F2F1; }
    //.jdd-comment > div:nth-child(3){ background : #CE2B37; }

    .flex > div:hover
    {
        width: 200px;
    }

</style>
