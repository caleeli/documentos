<template>
    <div>
        <textarea class="form-control input" rows="2"></textarea>
        <div class="output"><span></span></div>
        <div class="xy"></div>
    </div>
</template>

<script>
    export default {
        props: {
            placeholder: String,
            data: Array,
            value: null,
            filterBy: String,
            idField: String
        },
        data() {
            return {
                localValue: null,
                text: '',
                dataFiltered: [],
                inputFocus: false
            }
        },
        computed: {
            selected() {
                let value = this.value;
                return this.data.find(item => {
                    return value == this.getKey(item);
                });
            }
        },
        watch: {
            data() {
                this.filter();
            },
            text() {
                this.filter();
            }
        },
        methods: {
            getKey(row) {
                return Object.evaluateRef(row, this.idField ? this.idField : 'id');
            },
            textValue(value) {
                return $('<i></i>').text(value).html();
            },
            format(input) {
                let value = this.textValue(input);
                if (!this.text) {
                    return value;
                }
                let text = this.text;
                let length = text.length;
                let res = '';
                let u = -1;
                let i;
                while ((i = value.toLowerCase().localeIndexOf(text, 'en', {sensitivity: 'base'})) > -1) {
                    res += value.substr(0, i);
                    res += '<code>';
                    res += value.substr(i, length);
                    res += '</code>';
                    u = i + length;
                    value = value.substr(u);
                }
                res += value;
                return res;
            },
            filter() {
                var filterBy = this.filterBy ? this.filterBy.trim() : '';
                var filters = filterBy ? filterBy.split(/[, ]+/) : [];
                const dataFiltered = this.data.filterBy(filters, this.text, (item, value) => {
                    return this.textValue(item).localeIndexOf(value, 'en', {sensitivity: 'base'}) > -1;
                });
                this.dataFiltered.splice(0);
                for (let i = 0, l = dataFiltered.length; i < l; i++) {
                    this.dataFiltered.push(dataFiltered[i]);
                }
            },
            isOpen() {
                return $(this.$el).find("ul:first").is(':visible');
            },
            click() {
                setTimeout(() => {
                    if (!this.isOpen()) {
                        $(this.$el).find(".dropdown-menu").toggle();
                    }
                }, 100);
            },
            focus() {
                this.inputFocus = true;
                setTimeout(() => {
                    if (!this.isOpen()) {
                        $(this.$el).find(".dropdown-menu").toggle();
                    }
                }, 100);
            },
            blur() {
                this.inputFocus = false;
                setTimeout(() => {
                    if (this.isOpen()) {
                        $(this.$el).find(".dropdown-menu").toggle();
                    }
                }, 500);
            },
            select(row) {
                this.$emit('input', this.getKey(row));
                $(this.$el).find(".selected-option").focus();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .input, .output {
        position:absolute;
        top:0;
        left:0;
        font:14px/1 monospace;
        padding:5px;
        border:1px solid .999;
        white-space:pre;
        margin:0;
        background:transparent;
        width:300px;
        max-width:300px;
    }

    .input { 
        z-index:2;
        min-height:200px;
    }

    .output { 
        border-color:transparent; 
    }
    .output span {
        opacity:0;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .xy { 
        position:absolute; 
        width:4px;
        height:4px;
        background:#f00;
    }
</style>
