<?php

namespace App\Http\Controllers;

use App\Models\Log;
use ClickHouseDB\Client;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function getEventsCount()
    {
        $db = new Client(config('services.clickhouse'));
        $db->database('default');

        $rows = $db->select('SELECT count(*) AS logs_count, events.name AS event_name FROM logs INNER JOIN events ON events.uuid = logs.event_uuid GROUP BY events.name');
        $result = collect($rows->rows());

        return response()->json($result);
    }
}
