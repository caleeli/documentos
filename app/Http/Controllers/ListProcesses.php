<?php

namespace App\Http\Controllers;

use ProcessMaker\Nayra\Storage\BpmnDocument;
use ProcessMaker\Nayra\Storage\BpmnElement;
use App\Facades\JDD;

/**
 * Description of ListProcesses
 *
 */
trait ListProcesses
{

    /**
     * Obtiene la lista de procesos instalados en el sistema.
     *
     * @return array
     */
    private function listProcesses()
    {
        $refs = [];
        $processDefinitions = JDD::getBpmnProcesses();
        $bpmn = new BpmnDocument();
        foreach ($processDefinitions as $name => $def) {
            list($module, $filename) = $def;
            $source = file_get_contents($filename);
            $bpmn->loadXML($source);
            $starts = $bpmn->getElementsByTagNameNS(BpmnDocument::BPMN_MODEL,
                'startEvent');
            foreach ($starts as $start) {
                $id = $start->getAttribute('id');
                $description = $this->getDocumentation($start);
                $images = glob(public_path('/modules/' . $module->name . '/img/' . $id . '.*'));
                $icon = isset($images[0]) ? substr($images[0],
                        strlen(public_path(''))) : '/images/logo.png';
                $refs[$name . '_' . $id] = [
                    'text' => $start->getAttribute('name'),
                    'icon' => $icon,
                    'description' => $description,
                    'href' => '/ProcessStart/' . $name . '/' . $id,
                ];
            }
        }
        return $refs;
    }

    /**
     * Obtiene la documentcion de un nodo.
     *
     * @param BpmnElement $node
     *
     * @return string
     */
    private function getDocumentation(BpmnElement $node)
    {
        $text = '';
        $docs = $node
            ->getElementsByTagNameNS(BpmnDocument::BPMN_MODEL, 'documentation');
        foreach ($docs as $doc) {
            $text .= $doc->textContent;
        }
        return $text;
    }
}
