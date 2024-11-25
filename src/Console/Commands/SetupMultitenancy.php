<?php

namespace Xshop\Multitenancy\Console\Commands;

use Illuminate\Console\Command;
use Xshop\Multitenancy\Actions\CreateMainTenantDatabase;

class SetupMultitenancy extends Command
{
    protected $signature = 'multitenancy:setup';
    protected $description = 'Set up multitenancy configuration, and create initial tenant.';

    public function handle(CreateMainTenantDatabase $createDatabase)
    {
        $this->info('Setting up multitenancy...');
        $this->publishConfiguration();
        $this->info('Configuration published...');
        $createDatabase->execute();
        $this->info('Main landlord database created...');
        $this->info('Multitenancy setup completed successfully.');
    }

    protected function publishConfiguration()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Xshop\\Multitenancy\\XshopMultitenancyServiceProvider',
            '--tag' => 'config',
        ]);
    }
}
