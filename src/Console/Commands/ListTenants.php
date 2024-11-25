<?php

namespace Xshop\Multitenancy\Console\Commands;

use Illuminate\Console\Command;

class ListTenants extends Command
{
    protected $signature = 'multitenancy:list-tenants';
    protected $description = 'List all tenants from the tenants table in the landlord connection';

    public function handle()
    {
        $this->info('Fetching tenants from the landlord database...');

        $tenants = \DB::connection('landlord')->table('tenants')->get();

        if ($tenants->isEmpty()) {
            $this->info('No tenants found.');
            return 0;
        }

        $this->table(
            ['ID', 'Name', 'Domain', 'Database', 'Created At', 'Updated At'],
            $tenants->map(function ($tenant) {
                return [
                    $tenant->id,
                    $tenant->name,
                    $tenant->domain,
                    $tenant->database,
                    $tenant->created_at,
                    $tenant->updated_at,
                ];
            })->toArray()
        );

        return 0;
    }
}
