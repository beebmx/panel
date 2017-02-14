<?php

namespace Beebmx\Panel\Commands;

use Illuminate\Console\Command;

class ShowVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'panel:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show current Beebmx/Panel version';

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
        $this->info('Current version of Beebmx/Panel: '.config('panel.version')); 
    }
}
