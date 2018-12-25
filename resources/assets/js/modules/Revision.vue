<template>
    <panel name="Documento de revisión" class="panel-primary">
        <div class="revision">
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
                    <component :is="control.component" :config="config" :data="data"></component>
                </div>
                <div class="col-8" v-show="mode==='run'">
                    <div class="btn-group">
                        <button v-for="button in runButtons" type="button" class="btn btn-sm btn-outline-secondary" @click="doButton(button)">
                            <img v-if="button.icon" :src="button.icon">
                            {{button.label}}
                        </button>
                    </div>
                    <table>
                        <tr>
                            <td valign='top'><v-html ref="parsed" :template="parse" :data="data"></v-html></td>
                        <td valign='top'>
                            <div class="revision-comments">
                                <div v-for="(line,i) in lines" class="comment-line" :style="{top:line.top + 'px'}">
                                    <button type="button" @mouseover="highlight(i)" @mouseleave="leaveline" @click="activateComment(i)"><i class="fa fa-comment"></i></button>
                                    <div :class="{compact:activeComment!==i, expand:activeComment===i}">
                                        <comment v-model="line.comments" @open-comment="activateComment(i)">
                                            <a class="btn btn-sm float-right btn-outline-secondary"><i class="fa fa-plus"></i></a>
                                        </comment>
                                    </div>
                                </div>
                            </div>
                        </td>
                        </tr>
                    </table>
                </div>
            </div>
            <context-menu v-model="selectionListMenu" :element="selected">
                <grid v-if="listaActual==='empresas'" v-model="empresasData" filter-by="attributes.nombre_empresa">
                    <tr slot-scope="{row, options, format}" @click="listaSetValue(row.attributes.nombre_empresa)">
                        <td>{{row.id}}</td>
                        <td>{{row.attributes.nombre_empresa}}</td>
                    </tr>
                </grid>
            </context-menu>
        </div>
    </panel>
</template>

<script>
    import texto from './revision/texto';
    import ControlGenerico from './revision/ControlGenerico';
    import Comentario from './revision/Comentario';
    import componentesRevision from './revision/controls/componentes';
    import controlLista from './revision/controls/lista';
    import controlComentario from './revision/controls/comentario';
    import controlCheck from './revision/controls/check';
    Vue.component('texto', texto);
    require('../../images/revision/burbuja.svg');
    export default {
        components: {
            ControlGenerico,
            Comentario,
        },
        mixins: [componentesRevision, controlLista, controlComentario, controlCheck],
        props: {
        },
        data() {
            return {
                empresasData: new ApiArray('/api/empresas'),
                /**
                 * True para abrir el menu lista desplegable
                 */
                selectionListMenu: false,
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
                    {'handler': 'comentario', icon: require('../../images/revision/comentario.svg')},
                    {'handler': 'check', icon: require('../../images/revision/check.svg')},
                    {'handler': 'run', icon: require('../../images/revision/run.svg')},
                ],
                runButtons: [
                    {'handler': 'design', icon: require('../../images/revision/design.svg')},
                ],
                html: '',
                data: {},
                lines: [],
                activeComment: -1,
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
                    if (!config || !config.name)
                        return;
                    Vue.set(self.data, config.name, self.data[config.name] || '');
                    return '<texto v-model="data.' + config.name + '"></texto>';
                });
                return '<div class="revision-container">' + $div.html() + '</div>';
            }
        },
        watch: {
            mode() {
                this.$nextTick(() => {
                    this.lines.splice(0);
                    if (this.$refs.parsed) {
                        const position = $(this.$refs.parsed.$el).position();
                        for (let l = this.$refs.parsed.$el.children.length, i = 0; i < l; i++) {
                            let pos = $(this.$refs.parsed.$el.children.item(i)).position();
                            this.lines.push({
                                top: pos.top,
                                comments: [{header: 'david', body: 'este es un ejemplo de comentario'}],
                            });
                        }
                    }
                });
            }
        },
        methods: {
            activateComment(index) {
                this.activeComment = index;
            },
            leaveline() {
                const $parsed = $(this.$refs.parsed.$el);
                $parsed.children().removeClass('line-highlight');
            },
            highlight(index) {
                const $parsed = $(this.$refs.parsed.$el);
                const line = this.$refs.parsed.$el.children.item(index);
                $parsed.children().removeClass('line-highlight');
                $(line).addClass('line-highlight');
            },
            openControl(control) {
                if (this.config && this.selected != control) {
                    const inspector0 = this.inspector[this.config.type];
                    inspector0 && inspector0.blur instanceof Function ? inspector0.blur(this, this.config, this.selected) : null;
                }
                this.selected = control;
                if (control) {
                    const config = control ? this.handlers[control.nodeName](control) : {};
                    const inspector = this.inspector[config.type];
                    inspector && inspector.select instanceof Function ? inspector.select(this, config, control) : null;
                }
            },
            findControl(target) {
                return target.firstChild && this.handlers[target.firstChild.nodeName] !== undefined
                        ? target.firstChild : (this.handlers[target.parentNode.nodeName] !== undefined ? target.parentNode
                                : (this.handlers[target.nodeName] !== undefined ? target : null));
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
                });
            },
            empresas() {
                this.lista({
                    list: 'empresas',
                    name: 'empresa',
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
        updated() {
        },
        mounted() {
            $(this.$el).find('.revision-design').data('vue', this);
        },
    };
</script>

<style lang="scss">
    .revision {
        position: relative;
    }
    .token {
        width: 100%;
        height: 100%;
        border: 1px dashed gray;
        background-color: lightgoldenrodyellow;
        /* Fix a white box when hover the select on chrome */
	overflow: hidden;
    }
    .token-inline {
        border: 1px dashed gray;
        background-color: lightgoldenrodyellow;
        /* Fix a white box when hover the select on chrome */
	overflow: hidden;
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
    .comment-line {
        position:absolute;
    }
    .comment-line > button {
        border:1px solid lightblue;
        border-radius: 0.5em;
        position:absolute;
        width: 2em;
        height: 1.5em;
        line-height: normal;
        border-radius: 4px;
    }
    .comment-line > button:hover {
        border-radius: 4px 0px 0px 4px;
        border-right: none;
        background-color: lightblue;
    }
    .comment-line > div {
        position:absolute;
        left:2em;
        width:30em;
        overflow: hidden;
    }
    .comment-line > div.expand {
        height:10em;
        z-index: 2;
    }
    .comment-line > div.compact {
        height:2em;
    }
    .revision-comments {
        position: relative;
    }
    .line-highlight {
        background-color: lightblue;
    }
    .revision-container a {
        background-color: lightgoldenrodyellow;
    }
    .revision-container a:after {
        content: "";
        display: inline-block;
        width: 1em;
        height: 1em;
        background-image: url(/images/burbuja.svg);
        background-repeat: no-repeat;
        background-size: 100% auto;
        overflow: visible;
        position: absolute;
        margin-top: -0.25em;
    }
</style>
