<template>
    <div class="dropdown-menu" :style="xy">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            value: Boolean,
            element: null,
        },
        computed: {
            xy() {
                if (!this.element) {
                    return {display: 'none'};
                }
                const offsets = this.offsets(this.element);
                var top = offsets.reduce((i, e) => i + e.offsetTop, this.element.offsetHeight),
                        left = offsets.reduce((i, e) => i + e.offsetLeft, 0);
                return {
                    left: left + 'px',
                    top: top + 'px',
                    display: this.value ? 'block' : 'none',
                    width: this.element.offsetWidth + 'px',
                };
            },
        },
        methods: {
            offsets(element) {
                const offsets = [];
                do {
                    offsets.push(element);
                    element = element.offsetParent;
                    if (!element) {
                        // Common offset parent not found
                        return [];
                    }
                } while (element !== this.$el.parentElement);
                return offsets;
            },
        },
    }
</script>

<style lang="scss" scoped>
    .text-box-wraper {
        position: relative;
    }
    .output {
        position:absolute;
        top:0;
        left:0;
        font:inherit;
        font-size:1rem;
        padding:6px 12px;
        border:1px solid #999;
        margin:0;
        background:transparent;
        width:100%;
        white-space: pre-wrap;
        height: 100%;
        overflow-y: auto;
    }

    .input { 
        z-index:2;
        position:relative;
    }

    .output { 
        border-color:transparent; 
    }
    .output span {
        //opacity:0;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .xy { 
        position:absolute; 
        left: 13px;
        top: 10px;
        z-index: 3;
    }
</style>
