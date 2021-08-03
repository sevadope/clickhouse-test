<?php

namespace Database\Seeders;

use App\Models\Event;
use ClickHouseDB\Client;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class LogSeeder extends Seeder
{
    private const COUNT = 20000000;
    private const CHUNKS_COUNT = 20000;

    private $events;
    private $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $db = new Client(config('services.clickhouse'));
        $db->database('default');

        $this->faker = Factory::create();
        $events_statement = $db->select('SELECT * FROM events');

        $this->events = collect($events_statement->rows());

        $db->write('CREATE TABLE IF NOT EXISTS logs (uuid UUID, event_uuid UUID, body String) ENGINE = MergeTree() ORDER BY (uuid, body)');

        $plus = self::COUNT / self::CHUNKS_COUNT;

        for($chunk = 0; $chunk < self::COUNT; $chunk += $plus) {
            $rows = [];
            for ($i = 0; $i < $plus; $i++) {
                $rows[] = $this->make();
            }

            $db->insert('logs', $rows, $this->getColumns());
        }

        print("Logs successfully seeded.\n");
        info('Logs sucessfully seeded.');

        # for() / 1000
    }

    private function make()
    {
        return [
            Uuid::uuid4(),
            $this->faker->catchPhrase,
            $this->events->random()['uuid'],
        ];
    }

    private function getColumns()
    {
        return [
            'uuid',
            'body',
            'event_uuid',
        ];
    }
}
