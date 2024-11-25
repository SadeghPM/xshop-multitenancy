<?php
namespace Xshop\Multitenancy\Actions;

use Xshop\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\File;

class CreateLandlordDatabase
{
    public function execute(Tenant $tenant)
    {
        if (!file_exists($tenant->database)) {
            File::put($tenant->database, '');
        }
    }
}
