<?php

namespace App\Http\Controllers;

use App\Bpmn\Repository;
use App\Bpmn\TestEngine;
use App\Process;
use ProcessMaker\Nayra\Bpmn\Events\ActivityActivatedEvent;
use ProcessMaker\Nayra\Bpmn\Events\ActivityClosedEvent;
use ProcessMaker\Nayra\Bpmn\Events\ActivityCompletedEvent;
use ProcessMaker\Nayra\Bpmn\Events\ProcessInstanceCompletedEvent;
use ProcessMaker\Nayra\Bpmn\Events\ProcessInstanceCreatedEvent;
use ProcessMaker\Nayra\Contracts\Bpmn\ActivityInterface;
use ProcessMaker\Nayra\Contracts\Bpmn\ProcessInterface;
use ProcessMaker\Nayra\Contracts\Repositories\StorageInterface;
use ProcessMaker\Nayra\Storage\BpmnDocument;

class RevisionCarpetasController extends Controller
{

    /**
     * @var \ProcessMaker\Nayra\Contracts\RepositoryInterface $repository
     */
    private $repository;

    /**
     * @var \ProcessMaker\Nayra\Contracts\EventBusInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @var TestEngine $engine
     */
    private $engine;

    /**
     *
     * @var BpmnDocument $bpmnRepository
     */
    private $bpmnRepository;

    /**
     * @var \ProcessMaker\Nayra\Contracts\Bpmn\ProcessInterface $process
     */
    private $process;

    /**
     * @var array $storage
     */
    private $storage = [];

    public function __construct()
    {
        $this->repository = new Repository;
        $this->dispatcher = app('events');
        $this->engine = new TestEngine($this->repository, $this->dispatcher);

        //Load a BpmnFile Repository
        $this->bpmnRepository = new BpmnDocument();
        $this->bpmnRepository->setEngine($this->engine);
        $this->bpmnRepository->setFactory($this->repository);
        $mapping = $this->bpmnRepository->getBpmnElementsMapping();
        $this->bpmnRepository->setBpmnElementMapping(BpmnDocument::BPMN_MODEL,
            'userTask', $mapping[BpmnDocument::BPMN_MODEL]['task']);
        $this->bpmnRepository->setBpmnElementMapping(BpmnDocument::BPMN_MODEL,
            'association', BpmnDocument::SKIP_ELEMENT);
        $this->bpmnRepository->setBpmnElementMapping(BpmnDocument::BPMN_MODEL,
            'textAnnotation', BpmnDocument::SKIP_ELEMENT);
        $this->engine->setRepository($this->repository);
        $this->engine->setStorage($this->bpmnRepository);
        $this->bpmnRepository->load(__DIR__ . '/' . basename(__FILE__,
                'Controller.php') . '.bpmn');

        //Process
        $this->process = $this->bpmnRepository->getElementsByTagName('process')->item(0)->getBpmnElementInstance();

        //Se podria mover al app service provider
        $this->listenSaveEvents();
    }

    public function call()
    {
        $instance = $this->process->call();
        $this->engine->runToNextState();
        return response()->json([
                'instanceId' => $instance->getId(),
        ]);
    }

    public function completeTask()
    {
        $instanceId = request()->input('instanceId');
        $taskId = request()->input('elementId');
        //Load the execution instance
        $this->loadData($this->bpmnRepository, $instanceId);
        $instance = $this->engine->loadExecutionInstance($instanceId);

        //Get task instance
        $task = $this->bpmnRepository->getActivity($taskId);

        //Complete task
        foreach ($task->getTokens($instance) as $token) {
            $task->complete($token);
        }
        $this->engine->runToNextState();
    }

    private function loadData(StorageInterface $repository, $instanceId)
    {
        $executionInstanceRepository = $this->engine->getRepository()->createExecutionInstanceRepository($repository);
        $processData = Process::findOrNew($instanceId);
        $executionInstanceRepository->setRawData([
            $instanceId => [
                'id' => $instanceId,
                'processId' => $this->process->getId(),
                'data' => $processData->data,
                'tokens' => $processData->tokens,
            ]
        ]);
    }

    private function listenSaveEvents()
    {
        $this->dispatcher->listen(ProcessInterface::EVENT_PROCESS_INSTANCE_CREATED,
            function(ProcessInstanceCreatedEvent $payload) {
            $processData = Process::findOrNew($payload->instance->getId());
            $dataStore = $payload->instance->getDataStore();
            $processData->data = $dataStore->getData();
            $processData->tokens = [];
            $processData->status = 'ACTIVE';
            $processData->save();
            $payload->instance->setId($processData->id);
        });
        $this->dispatcher->listen(ProcessInterface::EVENT_PROCESS_INSTANCE_COMPLETED,
            function(ProcessInstanceCompletedEvent $payload) {
            $processData = Process::findOrFail($payload->instance->getId());
            $processData->status = 'COMPLETED';
            $processData->save();
            $payload->instance->setId($processData->id);
        });
        $this->dispatcher->listen(ActivityInterface::EVENT_ACTIVITY_ACTIVATED,
            function(ActivityActivatedEvent $event) {
            $id = $event->token->getInstance()->getId();
            $processData = Process::findOrFail($id);
            $tokens = $processData->tokens;
            $tokens[$event->token->getId()] = [
                'elementId' => $event->activity->getId(),
                'name' => $event->activity->getName(),
                'module' => $event->activity->getProperty('implementation'),
                'status' => $event->token->getStatus(),
            ];
            $processData->tokens = $tokens;
            $processData->save();
        });
        $this->dispatcher->listen(ActivityInterface::EVENT_ACTIVITY_COMPLETED,
            function(ActivityCompletedEvent $event) {
            $id = $event->token->getInstance()->getId();
            $processData = Process::findOrFail($id);
            $tokens = $processData->tokens;
            $tokens[$event->token->getId()] = [
                'elementId' => $event->activity->getId(),
                'name' => $event->activity->getName(),
                'module' => $event->activity->getProperty('implementation'),
                'status' => $event->token->getStatus(),
            ];
            $processData->tokens = $tokens;
            $processData->save();
        });
        $this->dispatcher->listen(ActivityInterface::EVENT_ACTIVITY_CLOSED,
            function(ActivityClosedEvent $event) {
            $id = $event->token->getInstance()->getId();
            $processData = Process::findOrFail($id);
            $tokens = $processData->tokens;
            $tokens[$event->token->getId()] = [
                'elementId' => $event->activity->getId(),
                'name' => $event->activity->getName(),
                'module' => $event->activity->getProperty('implementation'),
                'status' => $event->token->getStatus(),
            ];
            $processData->tokens = $tokens;
            $processData->save();
        });
    }
}
