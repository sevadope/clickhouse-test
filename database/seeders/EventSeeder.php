<?php

namespace Database\Seeders;

use App\Models\Event;
use ClickHouseDB\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use ClickHouseDB\Type\UInt64;

class EventSeeder extends Seeder
{
    public   const EVENTS = [
        'signup',
        'create',
        'update',
        'delete',
        'login',
        'logout',
        'show',
        'edit',
        'destroy',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $db = new Client(config('services.clickhouse'));
        $db->database('default');

        $db->write('CREATE TABLE IF NOT EXISTS events (uuid UUID, name String) ENGINE = MergeTree() ORDER BY (uuid, name)');

        $rows = [];
        foreach (self::EVENTS as $event) {
            $rows[] = $this->make($event);
        }

        $db->insert('events', $rows, $this->getColumns());
    }

    private function make(string $name)
    {
        return [
            Uuid::uuid4(),
            $name,
        ];
    }

    private function getColumns()
    {
        return [
            'uuid',
            'name',
        ];
    }
}
