<?php

namespace Xshop\Multitenancy\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Xshop\Multitenancy\Actions\CreateUser;
use Xshop\Multitenancy\Models\Tenant;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class CreateTenant extends Command
{
    protected $signature = 'multitenancy:create-tenant';
    protected $description = 'Create a new tenant with database, migrations, and seeders.';

    public function handle()
    {
        $this->info('Creating a new tenant...');

        $tenantDetails = $this->getTenantDetails();
        if (!$tenantDetails) {
            return;
        }

        $tenant = Tenant::create($tenantDetails);

        if ($tenant) {
            $this->createAdminUser($tenant);
        }

        $this->info('Tenant setup completed successfully.');
    }

    protected function getTenantDetails()
    {
        $tenantName = $this->ask('Enter the name of the tenant');
        $tenantDomain = $this->ask('Enter the domain of the tenant. (dont use http/https. ie: sample.com)');

        $validator = Validator::make(['domain' => $tenantDomain], [
            'domain' => 'not_in:https',
        ]);

        if ($validator->fails()) {
            $this->error('The tenant domain should not include "https" in the value.');
            return null;
        }

        return [
            'name' => $tenantName,
            'domain' => $tenantDomain,
        ];
    }

    protected function createAdminUser(Tenant $tenant)
    {

        $userName = $this->ask('Enter the name of the admin user');
        $userEmail = $this->ask('Enter the email of the admin user');
        $userPassword = $this->secret('Enter the password of the admin user');

        $action = new CreateUser($userName, $userEmail, $userPassword);
        $user = $action->execute($tenant);

        $this->info('Admin user has been created.');
    }
}
