<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Log;
use Database\Seeders\EventSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Log::class;

    private $events;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $random_event = $this->events ? $this->events->random() : ($this->events = Event::all())->random();

        return [
            'body' => 'text',
            'event_id' => $random_event->getKey(),
        ];
    }
}
