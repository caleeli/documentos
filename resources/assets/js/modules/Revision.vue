<template>
    <panel name="Documento de revisión" class="panel-primary">
        <div v-show="mode==='design'">
            <div class="btn-group">
                <button v-for="button in buttons" type="button" class="btn btn-sm btn-outline-secondary" @click="doButton(button)">
                    <img v-if="button.icon" :src="button.icon">
                    {{button.label}}
                </button>
            </div>
            <div contenteditable="true" @blur="setter" class="revision-container revision-design"></div>
        </div>
        <div v-show="mode==='run'">
            <div class="btn-group">
                <button v-for="button in runButtons" type="button" class="btn btn-sm btn-outline-secondary" @click="doButton(button)">
                    <img v-if="button.icon" :src="button.icon">
                    {{button.label}}
                </button>
            </div>
            <v-html :template="parse"></v-html>
        </div>
    </panel>
</template>

<script>
    export default {
        props: {
        },
        data() {
            return {
                mode: 'design',
                buttons: [
                    {'handler': 'justifyLeft', icon: require('../../images/revision/justify-left.svg')},
                    {'handler': 'justifyCenter', icon: require('../../images/revision/justify-center.svg')},
                    {'handler': 'justifyRight', icon: require('../../images/revision/justify-right.svg')},
                    {'handler': 'justifyFull', icon: require('../../images/revision/justify-full.svg')},
                    {'handler': 'table', icon: require('../../images/revision/table.svg')},
                    {'handler': 'addTr', icon: require('../../images/revision/add-tr.svg')},
                    {'handler': 'addTd', icon: require('../../images/revision/add-td.svg')},
                    {'handler': 'removeTr', icon: require('../../images/revision/remove-tr.svg')},
                    {'handler': 'removeTd', icon: require('../../images/revision/remove-td.svg')},
                    {'handler': 'texto', icon: require('../../images/revision/texto.svg')},
                    {'handler': 'empresas', icon: require('../../images/revision/empresa.svg')},
                    {'handler': 'run', icon: require('../../images/revision/run.svg')},
                ],
                runButtons: [
                    {'handler': 'design', icon: require('../../images/revision/design.svg')},
                ],
                html: ''
            }
        },
        computed: {
            getter() {
                return this.html;
            },
            parse(){
                let html = this.html;
                const $div = $('<div></div>').html(this.html);
                $div.find('select').replaceWith('<input class="form-control">');
                return '<div class="revision-container">' + $div.html() + '</div>';
            }
        },
        methods: {
            createToken(name) {
                return '<select class="token" size="1" multiple onclick=""><option>' + name + '</option></select>';
            },
            getCurrent() {
                let selection;
                if (window.getSelection)
                    selection = window.getSelection();
                else if (document.selection && document.selection.type !== "Control")
                    selection = document.selection;

                return selection.anchorNode; //current node on which cursor is positioned
            },
            doButton(button) {
                const handler = _.get(this, button.handler);
                handler instanceof Function ? handler() : null;
            },
            setter(event) {
                this.html = event.target.innerHTML;
            },
            link() {
                window.document.execCommand('createlink', false, 'https://www.google.com');
            },
            justifyLeft() {
                window.document.execCommand('justifyLeft');
            },
            justifyCenter() {
                window.document.execCommand('justifyCenter');
            },
            justifyRight() {
                window.document.execCommand('justifyRight');
            },
            justifyFull() {
                window.document.execCommand('justifyFull');
            },
            table() {
                window.document.execCommand('insertHTML', false, '<table border="1" class="jdd-table"><tr><td>jdd</td></tr></table>');
            },
            addTr() {
                const $tr = $(this.getCurrent()).parents('tr').first();
                $tr.after($tr.clone());
            },
            addTd() {
                const current = this.getCurrent();
                const $td = current.nodeName === 'TD' ? $(current) : $(current).parents('td').first();

                const index = $td[0].cellIndex;
                $td.parent().parent().children().each(function() {
                    let $td = $(this.cells[index]);
                    $td.after($td.clone());
                });
            },
            removeTr() {
                const $tr = $(this.getCurrent()).parents('tr').first();
                $tr.remove();
            },
            removeTd() {
                const current = this.getCurrent();
                const $td = current.nodeName === 'TD' ? $(current) : $(current).parents('td').first();
                const index = $td[0].cellIndex;
                $td.parent().parent().children().each(function() {
                    let $td = $(this.cells[index]);
                    $td.remove();
                });
            },
            texto() {
                window.document.execCommand('insertHTML', false, this.createToken('texto'));
            },
            empresas() {
                window.document.execCommand('insertHTML', false, this.createToken('empresa'));
            },
            run() {
                this.html = $(this.$el).find('.revision-design').html();
                /*loadRevisionBody({
                 template: '<div>' + this.html + '</div>'
                 });
                 this.redraw++;*/
                this.mode = "run";
            },
            design() {
                this.mode = "design";
            },
        },
        mounted() {
        },
    };
</script>

<style lang="scss">
    .token {
        width: 100%;
        height: 100%;
        border: 1px dashed gray;
        background-color: lightgoldenrodyellow;
    }
    .token option:checked { color: red; }
    .jdd-table {
        border-collapse: collapse;
        display: inline-table;
        border-color: black;
    }
    .jdd-table td {
        border-color: black;
    }
    .revision-container {
        width:8.5in;
        padding-left: 2cm;
        padding-top: 1.5cm;
        padding-right: 1.5cm;
    }
</style>
