<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    // GET /api/settings/rate-limit
    public function show()
    {
        return $this->payload();
    }

    // PUT /api/settings/rate-limit  { "enabled": true|false }
    public function update(Request $request)
    {
        $data = $request->validate(['enabled' => ['required', 'boolean']]);

        Cache::forever('rate_limit.enabled', (bool) $data['enabled']);

        return $this->payload();
    }

    private function payload(): array
    {
        return [
            'enabled' => (bool) Cache::get('rate_limit.enabled', true),
            'limits' => ['auth' => '5/min per IP', 'api' => '60/min per user or IP'],
        ];
    }
}
