<template>
    <div class="text-box-wraper">
        <textarea class="form-control input" rows="2" v-model="text" @keyup="update" @mouseup="update" @scroll="update"></textarea>
        <div class="output"><span></span></div>
        <div class="dropdown-menu" :style="xy">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            update() {
                const c = this.preSelection;
                const output = $(this.$el).find('.output')[0];
                const input = $(this.$el).find('.input')[0];
                if (!output || !input) {
                    return "";
                }
                const a = this.updated;
                const textarea = $(this.$el).find('textarea')[0];
                const selectionStart = textarea ? textarea.selectionStart : 0;
                output.firstChild.innerHTML = this.text.substr(0, selectionStart) + ".";
                var rects = output.firstChild.getClientRects(),
                        bounding = output.getBoundingClientRect(),
                        lastRect = rects[ rects.length - 1 ],
                        top = lastRect.top - input.scrollTop - bounding.top,
                        left = lastRect.left + lastRect.width - bounding.left;
                this.xy = "top: " + top + "px;left: " + left + "px; display:block;";
            }
        },
        data() {
            return {
                text: '',
                updated: 0,
                xy: '',
            };
        }
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
