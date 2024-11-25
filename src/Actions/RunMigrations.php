<?php

namespace Xshop\Multitenancy\Actions;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Xshop\Multitenancy\Models\Tenant;

class RunMigrations
{
    public function execute(Tenant $tenant)
    {
        Artisan::call('migrate', [
            '--database' => $tenant->slug,
            '--path' => 'database/migrations',
        ]);
    }
}
