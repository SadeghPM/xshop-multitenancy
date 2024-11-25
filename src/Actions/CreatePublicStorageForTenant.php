<?php

namespace Xshop\Multitenancy\Actions;

use Illuminate\Support\Facades\File;
use Xshop\Multitenancy\Models\Tenant;

class CreatePublicStorageForTenant
{
    public function execute(Tenant $tenant)
    {
        $publicStoragePath = storage_path("app/public/{$tenant->slug}");
        $publicLinkPath = public_path($tenant->slug);

        if (!is_dir($publicStoragePath)) {
            mkdir($publicStoragePath, 0755, true);
        }

        if (!File::exists($publicLinkPath)) {
            File::link($publicStoragePath, $publicLinkPath);
        }
    }
}
