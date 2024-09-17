<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class getDbName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Database Name';

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
        $dbName = DB::connection()->getDatabaseName();
        $this->info('Current Database Name is '. $dbName);
        return 0;
    }
}
