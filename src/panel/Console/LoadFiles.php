<?php

namespace Beebmx\Panel\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use File;
use Artisan;

class LoadFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'panel:files {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load Beebmx/Panel files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();
        
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $force = $this->option('force');
        if (File::exists(app_path('Panel/Blueprints/'))){        
            if ($force) {
                Artisan::call('vendor:publish', [
                    '--provider' => 'Beebmx\Panel\ServiceProvider',
                    '--tag' => 'config',
                    '--force' => true,
                ]);
                $this->info('Files was forced to be loaded.');
            }
        }else{
            Artisan::call('vendor:publish', [
                '--provider' => 'Beebmx\Panel\ServiceProvider',
                '--tag' => 'config',
                '--force' => $force ? true : false,
            ]);
            if ($force) {
                $this->info('Files was forced to be loaded.');
            }
        }
        $this->composer->dumpAutoloads();
        Artisan::call('optimize');
        $this->info('Files loaded successfully.');
    }
}
