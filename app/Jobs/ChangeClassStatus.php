<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeClassStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $class;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->class->update(['status' => 'Active']);
    }
}
