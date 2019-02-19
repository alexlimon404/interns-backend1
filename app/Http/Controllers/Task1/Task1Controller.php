<?php

namespace App\Http\Controllers\Task1;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Task1Controller extends Model
{
    public function helloWorld()
    {
        return 'Hello world';
    }

    public function uuid()
    {
        $uuid1 = Uuid::uuid1();
        return response()->json([
            'success' => 'true',
            'data' => [
                'uuid' => $uuid1->toString()
            ]
        ]);

    }

    public function dataFromConfig()
    {
        return response()->json([
            'success' => 'true',
            'data' => [
                'config' => [
                    'test_config_value' => env('TEST_CONFIG_VALUE')
                ]
            ]
        ]);
    }
}
