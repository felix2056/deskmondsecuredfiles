<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Models\Tenant\Classes;

class ChangeClassStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update class status on specified date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $classes = Classes::where('status', 'Scheduled')
            ->where('startDate', '>=', today())
            ->orderBy('startDate','DESC')
            ->get();

        foreach ($classes as $class) {
            $class->status = "Active";
            $class->save();

            $this->info($class->title . ' has been set to ' . $class->status);
        }
    }
}
