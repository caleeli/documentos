<template>
    <div class="text-box-wraper">
        <textarea class="form-control input" rows="2" v-model="text" @keyup="update" @mouseup="update" @scroll="update"></textarea>
        <div class="output"><span></span></div>
        <div class="dropdown-menu" :style="xy">
            <slot name="dropdown" v-bind:code="code" v-bind:select="select"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: String,
            reference: Function,
        },
        methods: {
            select(row) {
                const textarea = $(this.$el).find('textarea')[0];
                if (textarea) {
                    textarea.setRangeText(
                            this.reference(row),
                            textarea.selectionStart - this.code.length,
                            textarea.selectionEnd
                            );
                    this.text = textarea.value;
                    this.update();
                    textarea.focus();
                    textarea.setSelectionRange(textarea.selectionEnd, textarea.selectionEnd);
                }
            },
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
                const text = this.text.substr(0, selectionStart);
                output.firstChild.innerHTML = text + ".";
                var rects = output.firstChild.getClientRects(),
                        bounding = output.getBoundingClientRect(),
                        lastRect = rects[ rects.length - 1 ],
                        top = lastRect.top - input.scrollTop - bounding.top,
                        left = lastRect.left + lastRect.width - bounding.left;
                const match = text.match(/#(\w+)$/);
                this.code = match ? String(match[1]) : '';
                this.xy = "top: " + top + "px;left: " + left + "px; display: " + (match ? "block" : "none") + ";";
            }
        },
        watch: {
            text() {
                this.$emit('input', this.text);
            },
            value() {
                this.text = this.value;
            }
        },
        data() {
            return {
                text: this.value ? this.value : "",
                updated: 0,
                xy: '',
                code: '',
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
