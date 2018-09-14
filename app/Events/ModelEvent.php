<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelEvent implements ShouldBroadcast
{

    use Dispatchable,
        InteractsWithSockets,
        SerializesModels;

    public $event;
    public $model;

    /**
     * Create a new event instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $event
     *
     * @return void
     */
    public function __construct(Model $model, $event)
    {
        $this->event = $event;
        $this->model = str_replace('\\', '.', get_class($model));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('model-channel');
    }

    /**
     * Data of the event.
     * 
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'model' => $this->model,
            'event' => $this->event,
        ];
    }
}
