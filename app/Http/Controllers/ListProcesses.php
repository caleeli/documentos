<?php

namespace App\Http\Controllers;

use ProcessMaker\Nayra\Storage\BpmnDocument;
use ProcessMaker\Nayra\Storage\BpmnElement;

/**
 * Description of ListProcesses
 *
 * @author David Callizaya <davidcallizaya@gmail.com>
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
        $files = glob(app_path('Processes/*.bpmn'));
        $bpmn = new BpmnDocument();
        foreach ($files as $filename) {
            $name = basename($filename, '.bpmn');
            $source = file_get_contents($filename);
            $bpmn->loadXML($source);
            $starts = $bpmn->getElementsByTagNameNS(BpmnDocument::BPMN_MODEL,
                'startEvent');
            foreach ($starts as $start) {
                $id = $start->getAttribute('id');
                $description = $this->getDocumentation($start);
                $refs[$name . '_' . $id] = [
                    'text' => $start->getAttribute('name'),
                    'icon' => '/images/processes/' . $name . '/' . $id . '.svg',
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
