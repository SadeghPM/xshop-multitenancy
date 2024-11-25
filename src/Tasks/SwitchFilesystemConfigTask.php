<?php

namespace Xshop\Multitenancy\Tasks;

use Illuminate\Support\Facades\Config;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class SwitchFilesystemConfigTask implements SwitchTenantTask
{
    protected $originalConfig;

    public function makeCurrent(IsTenant $tenant): void
    {
        $config = [
            'disks' => [
                'public' => [
                    'driver' => 'local',
                    'root' => storage_path("app/public/{$tenant->slug}"),
                    'url' => \config('app.url') . "/$tenant->slug",
                    'visibility' => 'public',
                ],
            ],
        ];
        $this->originalConfig = Config::get('filesystems');
        Config::set('filesystems', array_merge(Config::get('filesystems'), $config));
    }

    public function forgetCurrent(): void
    {
        Config::set('filesystems', $this->originalConfig);
    }
}
