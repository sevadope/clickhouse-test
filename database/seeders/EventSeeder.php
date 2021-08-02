<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

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
        $rows = [];

        foreach (self::EVENTS as $event) {
            $rows[] = $this->make($event);
        }

        Event::insert($rows);
    }

    private function make(string $name)
    {
        return [
            'name' => $name,
        ];
    }
}
