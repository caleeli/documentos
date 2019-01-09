<?php

namespace App\Http\Controllers;

use App\Bpmn\Repository;
use App\Bpmn\TestEngine;
use App\Process;
use Illuminate\Http\Request;
use ProcessMaker\Nayra\Bpmn\Events\ActivityActivatedEvent;
use ProcessMaker\Nayra\Bpmn\Events\ActivityClosedEvent;
use ProcessMaker\Nayra\Bpmn\Events\ActivityCompletedEvent;
use ProcessMaker\Nayra\Bpmn\Events\ProcessInstanceCompletedEvent;
use ProcessMaker\Nayra\Bpmn\Events\ProcessInstanceCreatedEvent;
use ProcessMaker\Nayra\Contracts\Bpmn\ActivityInterface;
use ProcessMaker\Nayra\Contracts\Bpmn\ProcessInterface;
use ProcessMaker\Nayra\Contracts\Bpmn\TokenInterface;
use ProcessMaker\Nayra\Contracts\Repositories\StorageInterface;
use ProcessMaker\Nayra\Storage\BpmnDocument;
use ProcessMaker\Nayra\Contracts\Engine\ExecutionInstanceInterface;

class ProcessController extends Controller
{

    use ListProcesses;

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

    /**
     * @var string $bpmn
     */
    private $bpmn;

    /**
     * @var ExecutionInstanceInterface $instance
     */
    private $instance;

    /**
     * @var Process $processData
     */
    private $processData;

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
        $this->bpmnRepository->setBpmnElementMapping(BpmnDocument::BPMN_MODEL,
            'documentation', BpmnDocument::SKIP_ELEMENT);
        $this->bpmnRepository->setBpmnElementMapping(BpmnDocument::BPMN_MODEL,
            'humanPerformer', BpmnDocument::SKIP_ELEMENT);
        $this->engine->setRepository($this->repository);
        $this->engine->setStorage($this->bpmnRepository);

        //Se podria mover al app service provider
        $this->listenSaveEvents();
    }

    public function call()
    {
        $this->bpmnRepository->load(__DIR__ . '/' . basename(__FILE__,
                'Controller.php') . '.bpmn');

        //Process
        $this->process = $this->bpmnRepository->getElementsByTagName('process')->item(0)->getBpmnElementInstance();
        $instance = $this->process->call();
        $this->engine->runToNextState();
        return response()->json([
                'instanceId' => $instance->getId(),
        ]);
    }

    public function start(Request $request)
    {
        //Process
        $process = $this->loadProcess($request->input('process'));
        $event = $this->bpmnRepository->getStartEvent($request->input('event'));

        //Create a new data store
        $dataStorage = $process->getRepository()->createDataStore();
        $dataStorage->setData($request->input('data', []));
        $instance = $process->getEngine()->createExecutionInstance($process,
            $dataStorage);
        $event->start();

        $this->engine->runToNextState();
        return response()->json([
                'instanceId' => $instance->getId(),
        ]);
    }

    /**
     * Obtiene la lista de tareas del proceso para el usuario actual.
     *
     * @param Request $request
     * @return type
     */
    public function tasks(Request $request)
    {
        //Load the execution data
        $instanceId = request()->input('id');
        $this->processData = $this->loadData($this->bpmnRepository, $instanceId);

        //Process and instance
        $instance = $this->engine->loadExecutionInstance($instanceId);

        $links = [];
        foreach ($instance->getTokens() as $token) {
            $links[] = $this->accessLink($token, $instance);
        }

        return response()->json($links);
    }

    public function completeTask($instanceId, $tokenId)
    {
        //Load the execution data
        $this->loadData($this->bpmnRepository, $instanceId);

        //Process and instance
        $instance = $this->engine->loadExecutionInstance($instanceId);

        //Get task instance
        $data = request()->all();
        foreach ($data as $key => $value) {
            $instance->getDataStore()->putData($key, $value);
        }

        //Complete task
        foreach ($instance->getTokens() as $token) {
            if ($token->getId() === $tokenId) {
                $task = $this->bpmnRepository->getActivity($token->getProperty('elementId'));
                $task->complete($token);
                break;
            }
        }
        $this->engine->runToNextState();

        //Return the instance id
        return response()->json(['instanceId' => $instance->getId()]);
    }

    /**
     * Cancela un proceso por id de instancia.
     *
     * @param string $instance
     *
     * @return json
     */
    public function cancel($instance)
    {
        //Load the execution data
        $processData = $this->loadData($this->bpmnRepository, $instance);

        $processData->status = 'CANCELED';
        $processData->save();

        //Return the instance id
        return response()->json(['instance' => $instance]);
    }

    /**
     * Carga un proceso BPMN
     *
     * @param string $processName
     *
     * @return ProcessInterface
     */
    private function loadProcess($processName)
    {
        $this->bpmn = $processName;
        $this->bpmnRepository->load(app_path('Processes/' . $processName . '.bpmn'));

        //Process
        $process = $this->bpmnRepository->getElementsByTagName('process')->item(0)->getBpmnElementInstance();

        return $process;
    }

    /**
     * Carga los datos de la instancia almacenados en la BD.
     *
     * @param StorageInterface $repository
     * @param type $instanceId
     *
     * @return Process
     */
    private function loadData(StorageInterface $repository, $instanceId)
    {
        $executionInstanceRepository = $this->engine->getRepository()->createExecutionInstanceRepository($repository);
        $processData = Process::findOrFail($instanceId);
        $this->loadProcess($processData->bpmn);
        $executionInstanceRepository->setRawData([
            $instanceId => [
                'id' => $instanceId,
                'processId' => $processData->process_id,
                'data' => $processData->data,
                'tokens' => $processData->tokens,
            ]
        ]);
        return $processData;
    }

    private function listenSaveEvents()
    {
        $this->dispatcher->listen(ProcessInterface::EVENT_PROCESS_INSTANCE_CREATED,
            function(ProcessInstanceCreatedEvent $payload) {
            $processData = Process::findOrNew($payload->instance->getId());
            $dataStore = $payload->instance->getDataStore();
            $processData->process_id = $payload->instance->getProcess()->getId();
            $processData->data = $dataStore->getData();
            $processData->tokens = [];
            $processData->status = 'ACTIVE';
            $processData->bpmn = $this->bpmn;
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
            $dataStore = $event->token->getInstance()->getDataStore();
            $tokens = $processData->tokens;
            $tokens[$event->token->getId()] = [
                'elementId' => $event->activity->getId(),
                'name' => $event->activity->getName(),
                'module' => $event->activity->getProperty('implementation'),
                'status' => $event->token->getStatus(),
            ];
            $processData->tokens = $tokens;
            $processData->data = $dataStore->getData();
            $processData->save();
        });
        $this->dispatcher->listen(ActivityInterface::EVENT_ACTIVITY_COMPLETED,
            function(ActivityCompletedEvent $event) {
            $id = $event->token->getInstance()->getId();
            $processData = Process::findOrFail($id);
            $dataStore = $event->token->getInstance()->getDataStore();
            $tokens = $processData->tokens;
            $tokens[$event->token->getId()] = [
                'elementId' => $event->activity->getId(),
                'name' => $event->activity->getName(),
                'module' => $event->activity->getProperty('implementation'),
                'status' => $event->token->getStatus(),
            ];
            $processData->tokens = $tokens;
            $processData->data = $dataStore->getData();
            $processData->save();
        });
        $this->dispatcher->listen(ActivityInterface::EVENT_ACTIVITY_CLOSED,
            function(ActivityClosedEvent $event) {
            $id = $event->token->getInstance()->getId();
            $processData = Process::findOrFail($id);
            $dataStore = $event->token->getInstance()->getDataStore();
            $tokens = $processData->tokens;
            $tokens[$event->token->getId()] = [
                'elementId' => $event->activity->getId(),
                'name' => $event->activity->getName(),
                'module' => $event->activity->getProperty('implementation'),
                'status' => $event->token->getStatus(),
            ];
            $processData->tokens = $tokens;
            $processData->data = $dataStore->getData();
            $processData->save();
        });
    }

    /**
     * Obtiene el access link para la actividad.
     *
     * @param TokenInterface $token
     * @param string $instanceId
     * @return array
     */
    private function accessLink(TokenInterface $token, ExecutionInstanceInterface $instance)
    {
        $this->instance = $instance;
        $instanceId = $instance->getId();
        $properties = $token->getProperties();
        $id = $properties['elementId'];
        $node = $this->bpmnRepository->findElementById($id);
        $task = $this->bpmnRepository->getActivity($id);
        $description = $this->getDocumentation($node);
        $implementation = $node->getAttribute('implementation');
        return [
            'token' => $token->getId(),
            'text' => $task->getName(),
            'icon' => '/images/processes/' . $this->bpmn . '/' . $task->getId() . '.svg',
            'description' => $description,
            'href' => $this->evaluateString($implementation ? $implementation : '/Process/Open/' . $instanceId)
            . sprintf('?instance=%s&token=%s', $instanceId, $token->getId()),
        ];
    }

    private function evaluateCode($code)
    {
        extract($this->instance->getDataStore()->getData());
        return eval("return $code;");
    }

    private function evaluateString($string)
    {
        return preg_replace_callback('/\{(.+)\}/',
            function ($match) {
            return $this->evaluateCode($match[1]);
        }, $string);
    }
}
