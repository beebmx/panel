<?php

namespace Beebmx\Panel\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use File;

class CreateBlueprint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'panel:blueprint {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Beebmx/Panel Blueprint file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = trim($this->argument('name'));
        $yml = $this->getYml();
        $strings_search = array('Name', 'ntable', 'nstorage');
        $strings_replace = array(studly_case($name), $name, str_singular($name));
        $yml = str_replace($strings_search, $strings_replace, $yml);
        
        if (!File::exists(app_path('Panel/Blueprints/'.$name.'.yml'))){
            File::put(app_path('Panel/Blueprints/'.$name.'.yml'), $yml);
            $this->info('Blueprint created successfully.'); 
        }else{
            $this->error('[Error] Blueprint already exists.'); 
        }
    }

    protected function getYml()
    {
        return File::get(__DIR__.'/../templates/blueprint.yml');
    }
}
