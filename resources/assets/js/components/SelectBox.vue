<template>
    <div class="select-owner">
        <div v-if="selected && !inputFocus" class="selected-option"><slot :row="selected" :format="textValue"></slot></div>
        <div v-if="!(selected && !inputFocus) && !inputFocus" class="selected-option">{{value}}</div>
        <input  class="form-control selected-input dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"
                @focus="focus" @blur="blur" @click="click"
                v-model="text">
        <ul class="dropdown-menu select-list">
            <li v-for="(row, index) in dataFiltered" v-bind:value="getKey(row)" v-if="index<5" class="dropdown-item" @click="select(row)">
            <slot :row="row" :format="format"></slot>
            </li>
        </ul>
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
            textShown() {
                const text = this.text;
                const value = this.value;
                return this.inputFocus ? text : value;
            },
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
            updateText(event) {
                this.text = event.target.value;
            },
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
                this.$emit('change', row);
                $(this.$el).find(".selected-option").focus();
            }
        },
        mounted() {
            this.filter();
        }
    }
</script>

<style lang="scss" scoped>
    .select-owner {
        position:relative;
    }
    .selected-option {
        position: absolute;
        padding: 0.375rem 0.75rem;
        pointer-events: none;
        overflow: hidden;
        white-space: nowrap;
        width: 100%;
    }
    .selected-input {
        color: transparent;
        background-color: transparent;
    }
    .selected-input:focus {
        color: inherit;
        background-color: inherit;
    }
    .select-list {
        max-width: 80vw;
        overflow: hidden;
    }
    .select-list .dropdown-item {
        font-weight: normal;
    }
</style>
