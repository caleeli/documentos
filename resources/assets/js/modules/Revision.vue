<template>
    <panel name="Documento de revisión" class="panel-primary">
        <div class="">
            <texto></texto>
            <div class="row">
                <div class="col-8" v-show="mode==='design'">
                    <div class="btn-group">
                        <button v-for="button in buttons" type="button" class="btn btn-sm btn-outline-secondary" @click="doButton(button)">
                            <img v-if="button.icon" :src="button.icon">
                            {{button.label}}
                        </button>
                    </div>
                    <div contenteditable="true" @blur="setter" @click="selectControl" @selectstart="selectControl" class="revision-container revision-design"></div>
                </div>
                <div class="col-4" v-show="mode==='design'">
                    <panel name="Propiedades" class="panel-secondary">
                        <div v-show="config.type">
                            <div class="form-group">
                                <label>Tipo</label>
                                <select v-model="config.type" class="form-control">
                                    <option value=""></option>
                                    <option value="text">Texto</option>
                                    <option value="select">Lista de selección</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input v-model="config.name" class="form-control" placeholder="nombre">
                            </div>
                            <div class="form-group">
                                <label>Datos</label>
                                <input v-model="config.data" class="form-control" placeholder="origen de datos">
                            </div>
                            <div class="form-group">
                                <label>Valor</label>
                                <input v-model="data[config.name]" class="form-control" placeholder="valor actual">
                            </div>
                        </div>
                    </panel>
                </div>
                <div class="col-8" v-show="mode==='run'">
                    <div class="btn-group">
                        <button v-for="button in runButtons" type="button" class="btn btn-sm btn-outline-secondary" @click="doButton(button)">
                            <img v-if="button.icon" :src="button.icon">
                            {{button.label}}
                        </button>
                    </div>
                    <v-html :template="parse" :data="data"></v-html>
                </div>
            </div>
        </div>
    </panel>
</template>

<script>
    import texto from './revision/texto';
    export default {
        components: {
            texto
        },
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
                html: '',
                selected: null,
                config: {},
                data: {},
            }
        },
        computed: {
            getter() {
                return this.html;
            },
            parse() {
                const self = this;
                const $div = $('<div></div>').html(this.html);
                $div.find('select').replaceWith(function() {
                    const config = JSON.parse(this.getAttribute('name'));
                    if (!config || !config.name) return;
                    Vue.set(self.data, config.name, self.data[config.name] || '');
                    return '<input class="form-control" v-model="data.' + config.name + '">';
                });
                return '<div class="revision-container">' + $div.html() + '</div>';
            }
        },
        watch: {
            config: {
                deep: true,
                handler() {
                    this.selected ? this.selected.setAttribute('name', JSON.stringify(this.config)) : null;
                }
            },
            selected(select) {
                const config = select ? JSON.parse(select.getAttribute('name')) : {};
                Vue.set(this, 'config', config);
            }
        },
        methods: {
            openControl(select) {
                this.selected = select;
            },
            findControl(target) {
                return target.firstChild && target.firstChild.nodeName === 'SELECT'
                        ? target.firstChild : (target.parentNode.nodeName === 'SELECT' ? target.parentNode
                                : (target.nodeName === 'SELECT' ? target : null));
            },
            selectControl(event) {
                const control = event.explicitOriginalTarget ? this.findControl(event.explicitOriginalTarget)
                        : this.findControl(event.target);
                control ? this.openControl(control) : this.openControl(null);
            },
            controlEvent(control, event, callback) {
                const code = callback.toString();
                control.attr(event, '(' + code + ')(event)');
            },
            createToken(config) {
                const control = $('<select class="token" size="1" multiple><option>' + config.name + '</option></select>');
                control.attr('name', JSON.stringify(config));
                const html = $('<div></div>').append(control).html();
                window.document.execCommand('insertHTML', false, html);
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
                this.createToken({
                    type: 'text',
                    name: 'texto',
                    value: '',
                });
            },
            empresas() {
                this.createToken({
                    type: 'select',
                    data: 'empresas',
                    name: 'empresa',
                    value: '',
                });
            },
            run() {
                this.html = $(this.$el).find('.revision-design').html();
                this.mode = "run";
            },
            design() {
                this.mode = "design";
            },
        },
        mounted() {
            $(this.$el).find('.revision-design').data('vue', this);
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
