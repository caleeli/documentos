<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ExampleEvent implements ShouldBroadcast
{

    use Dispatchable,
        InteractsWithSockets,
        SerializesModels;

    /**
     * Message of the event.
     *
     * @var string 
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('test-event');
    }

    /**
     * Data of the event.
     * 
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'message' => $this->message
        ];
    }
}
