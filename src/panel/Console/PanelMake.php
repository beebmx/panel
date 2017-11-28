<?php

namespace Beebmx\Panel\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use File;

class PanelMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'panel:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create basic panel integration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__.'/stubs/make/routes.stub'),
            FILE_APPEND
        );
    }
}
