<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AccountingRestInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounting-rest:install {--fresh} {--with-test-data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Accounting Rest Service.';

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
        $this->call('migrate' . ($this->option('fresh') ? ':fresh' : ''), []);
        if ($this->option('with-test-data')) {
            Artisan::call('db:seed', array('--class' => 'TestDataSeeder'));
        }
        $this->call('passport:install', []);
        $this->call('storage:link', []);
    }
}
