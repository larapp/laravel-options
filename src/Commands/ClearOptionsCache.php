<?php

namespace Larapp\Options\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Larapp\Options\Facade\Options;

class ClearOptionsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'options:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore options cache';

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
     * @return mixed
     */
    public function handle()
    {
        Options::restore();
        
        $this->info('Options successfully restored');
    }
}
