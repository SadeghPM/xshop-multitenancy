<?php

namespace Xshop\Multitenancy\Actions;

use Illuminate\Support\Facades\DB;

class ActivateDatabase
{
    public function execute($tenant)
    {
        config(['database.connections.' . $tenant->slug => [
            'driver' => 'sqlite',
            'database' => $tenant->database,
            'prefix' => '',
        ]]);

        DB::setDefaultConnection($tenant->slug);
    }
}
