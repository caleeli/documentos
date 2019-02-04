<template>
    <div class="text-box-wraper">
        <textarea class="form-control input" rows="2" v-model="text" @keyup="update" @mouseup="update" @scroll="update"></textarea>
        <div class="output"><span></span></div>
        <div class="links" @click="focus"><span v-html="textLinks"></span></div>
        <div class="dropdown-menu" :style="xy">
            <slot name="dropdown" v-bind:code="code" v-bind:select="select" v-bind:tag="tag"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: String,
            reference: Function,
            referenceUrl: Function,
            tags: String,
        },
        computed: {
            textLinks() {
                let text = this.text;
                if (this.tags) for (let i = 0; i < this.tags.length; i++) {
                    let exp = new RegExp(this.tags[i] + '(\\w+)\\s+[^)]+\\)|' + this.tags[i] + '(\\w+)');
                    text = text.replace(exp, (ma, id1, id2) => '<a target="_blank" href="' + this.referenceUrl(ma.substr(0,1), id1 || id2 )+ '" style="pointer-events:all;">' + ma + '</a>');
                }
                return text;
            },
        },
        methods: {
            focus() {
                const textarea = $(this.$el).find('textarea').focus();
            },
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
                this.xy = "top: " + top + "px;left: " + left + "px; display: none;";
                this.tag = '';
                for (let i = 0; i < this.tags.length; i++) {
                    let match = text.match(new RegExp(this.tags[i] + '(\\w+)$'));
                    if (match) {
                        this.code = match ? String(match[1]) : '';
                        this.xy = "top: " + top + "px;left: " + left + "px; display: block;";
                        this.tag = this.tags[i];
                        break;
                    }
                }
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
                tag: '',
            };
        }
    }
</script>

<style lang="scss" scoped>
    .text-box-wraper {
        position: relative;
    }
    .output, .links {
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
    
    .links {
        z-index:3;
        pointer-events: none;
    }

    .output, .links { 
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
