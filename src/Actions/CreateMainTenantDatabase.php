<?php

namespace Xshop\Multitenancy\Actions;

use Illuminate\Support\Facades\File;
use Xshop\Multitenancy\Models\Tenant;

class CreateMainTenantDatabase
{
    public function execute()
    {
        $databasePath = database_path('tenant-db.sqlite');
        if (!File::exists($databasePath)) {
            File::put($databasePath, '');
        }

        // Set the database connection to use the SQLite database
        config(['database.connections.sqlite.database' => $databasePath]);

        // Create the tenants table using raw SQL
        \DB::connection('sqlite')->statement(
            query: 'CREATE TABLE IF NOT EXISTS tenants (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                domain TEXT NOT NULL UNIQUE,
                database TEXT NOT NULL UNIQUE,
                meta TEXT,
                created_at TEXT,
                updated_at TEXT
            )'
        );
    }
}
