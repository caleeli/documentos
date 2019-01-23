<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProcessMaker\Nayra\Contracts\Bpmn\ScriptTaskInterface;
use ProcessMaker\Nayra\Contracts\Bpmn\TokenInterface;
use App\Process;

class RunScript implements ShouldQueue
{

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ScriptTaskInterface $scriptTask, TokenInterface $token)
    {
        $this->process_id = $token->getInstance()->getId();
        $this->token_id = $token->getId();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $processData = Process::findOrFail($this->process_id);
    }
}
