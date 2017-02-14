<?php

namespace Beebmx\Panel\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use File;

class CreateField extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:field {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Beebmx/Panel Field class';

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
        $name = trim($this->argument('name'));
        $template = $this->getTemplate();
        $strings_search = array('NameField');
        $strings_replace = array(studly_case($name.'Field'));
        $template = str_replace($strings_search, $strings_replace, $template);
        
        if (!File::exists(app_path('Panel/Fields/'.$name.'/'.$name.'.php'))){
            $this->isDirectoryCreated(app_path('Panel/Fields/'.$name));
            File::put(app_path('Panel/Fields/'.$name.'/'.$name.'.php'), $template);  
            $this->info('Field created successfully.'); 
        }else{
            $this->error('[Error] Field already exists.'); 
        }
    }

    protected function getTemplate()
    {
        return File::get(__DIR__.'/../templates/field.php');
    }
    
    protected function isDirectoryCreated($path){
        if (!File::isDirectory($path)){
            File::makeDirectory($path, 0755, true, true);
        }
    }
}
