<template>
    <div class="dropdown-menu" :style="xy">
        <slot name="dropdown" v-bind:code="code"></slot>
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
                    return {display: 'none', opacity: 0};
                }
                console.log(this.element);
                var top = this.element.offsetTop + this.element.scrollTop,
                        left = this.element.offsetLeft + this.element.scrollLeft;
                return {left: left + 'px', top: top + 'px', opacity: 1};
            },
        },
        methods: {
        },
        watch: {
            element() {

            },
        },
        data() {
            return {
                text: this.value ? this.value : "",
                updated: 0,
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


<?xml version="1.0" encoding="UTF-8"?>
<bpmn:definitions xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:bpmn="http://www.omg.org/spec/BPMN/20100524/MODEL" xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI" xmlns:dc="http://www.omg.org/spec/DD/20100524/DC" xmlns:di="http://www.omg.org/spec/DD/20100524/DI" xmlns:pm="http://processmaker.com/BPMN/2.0/Schema.xsd" xmlns:tns="http://sourceforge.net/bpmn/definitions/_1530553328908" xmlns:xsd="http://www.w3.org/2001/XMLSchema" targetNamespace="http://bpmn.io/schema/bpmn" exporter="ProcessMaker Modeler" exporterVersion="1.0" xsi:schemaLocation="http://www.omg.org/spec/BPMN/20100524/MODEL http://bpmn.sourceforge.net/schemas/BPMN20.xsd">
  <bpmn:process id="ProcessId" name="ProcessName" isExecutable="true">
    <bpmn:startEvent id="node_2" name="Start Event">
      <bpmn:outgoing>node_6</bpmn:outgoing>
    </bpmn:startEvent>
    <bpmn:task id="node_31" name="New Task" pm:assignment="requestor">
      <bpmn:incoming>node_6</bpmn:incoming>
      <bpmn:outgoing>node_7</bpmn:outgoing>
    </bpmn:task>
    <bpmn:task id="node_4" name="New Task" pm:assignment="user">
      <bpmn:incoming>node_7</bpmn:incoming>
      <bpmn:outgoing>node_8</bpmn:outgoing>
    </bpmn:task>
    <bpmn:endEvent id="node_5" name="End Event">
      <bpmn:incoming>node_8</bpmn:incoming>
    </bpmn:endEvent>
    <bpmn:sequenceFlow id="node_6" sourceRef="node_2" targetRef="node_31" />
    <bpmn:sequenceFlow id="node_7" sourceRef="node_31" targetRef="node_4" />
    <bpmn:sequenceFlow id="node_8" sourceRef="node_4" targetRef="node_5" />
  </bpmn:process>
  <bpmndi:BPMNDiagram id="BPMNDiagramId">
    <bpmndi:BPMNPlane id="BPMNPlaneId" bpmnElement="ProcessId">
      <bpmndi:BPMNShape id="node_2_di" bpmnElement="node_2">
        <dc:Bounds x="220" y="130" width="36" height="36" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="node_3_di" bpmnElement="node_31">
        <dc:Bounds x="390" y="110" width="100" height="80" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="node_4_di" bpmnElement="node_4">
        <dc:Bounds x="620" y="120" width="100" height="80" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNShape id="node_5_di" bpmnElement="node_5">
        <dc:Bounds x="870" y="140" width="36" height="36" />
      </bpmndi:BPMNShape>
      <bpmndi:BPMNEdge id="node_6_di" bpmnElement="node_6">
        <di:waypoint x="256" y="148" />
        <di:waypoint x="390" y="148" />
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="node_7_di" bpmnElement="node_7">
        <di:waypoint x="490" y="150" />
        <di:waypoint x="620" y="150" />
      </bpmndi:BPMNEdge>
      <bpmndi:BPMNEdge id="node_8_di" bpmnElement="node_8">
        <di:waypoint x="720" y="160" />
        <di:waypoint x="787.8046875" y="160" />
        <di:waypoint x="787.8046875" y="158" />
        <di:waypoint x="870" y="158" />
      </bpmndi:BPMNEdge>
    </bpmndi:BPMNPlane>
  </bpmndi:BPMNDiagram>
</bpmn:definitions>
