<?php

namespace App\Console\Commands;

use ClickHouseDB\Client;
use Illuminate\Console\Command;

class WipeClickHouse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clickhouse:wipe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all ClickHouse tables';

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
        $db = new Client(config('services.clickhouse'));
        $db->database('default');

        $db->write('DROP TABLE IF EXISTS events');
        $db->write('DROP TABLE IF EXISTS logs');

        return 0;
    }
}
