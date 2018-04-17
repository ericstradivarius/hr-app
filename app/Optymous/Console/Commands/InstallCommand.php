<?php

namespace App\Optymous\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the app on your platform.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        collect([
            'migrate',
            'db:seed',
            'key:generate',
            'cache:clear',
            'config:clear',
            'optimize',
            'passport:install'
        ])->each(function($line) {
            $this->call($line);
        });

        $this->call('api:generate', [
            '--routePrefix' => 'api/*',
            '--noResponseCalls',
            '--header' => 'Accept: application/json'
        ]);

        copy(
            storage_path('app/docs-logo.png'),
            public_path('docs/images/logo.png')
        );
    }
}
