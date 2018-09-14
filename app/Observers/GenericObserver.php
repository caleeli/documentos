<?php
namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Events\ModelEvent;

class GenericObserver
{

    private function notify(Model $model, $method)
    {
        $event = new ModelEvent($model, explode('::', $method)[1]);
        broadcast($event);
    }

    private function notifyUser(User $user, Model $model, $method)
    {
        $event = new ModelEvent($model, $method);
        $user->notify($event);
    }

    /**
     * Handle the user "created" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function created(Model $model)
    {
        $this->notify($model, __METHOD__);
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function updated(Model $model)
    {
        $this->notify($model, __METHOD__);
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function deleted(Model $model)
    {
        $this->notify($model, __METHOD__);
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function restored(Model $model)
    {
        $this->notify($model, __METHOD__);
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function forceDeleted(Model $model)
    {
        $this->notify($model, __METHOD__);
    }
}
