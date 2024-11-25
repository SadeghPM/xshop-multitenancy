<?php

namespace Xshop\Multitenancy\Models;

use Illuminate\Support\Str;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;
use Xshop\Multitenancy\Actions\ActivateDatabase;
use Xshop\Multitenancy\Actions\CreateLandlordDatabase;
use Xshop\Multitenancy\Actions\CreatePublicStorageForTenant;
use Xshop\Multitenancy\Actions\RunMigrations;
use Xshop\Multitenancy\Actions\RunSeeders;

class Tenant extends BaseTenant
{
    protected $guarded = [];
    protected $casts = [
        'meta' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $appends = ['slug'];

    protected static function booted()
    {
        self::creating(function (Tenant $tenant) {
            $tenant->database = database_path(Str::slug($tenant->domain, dictionary: ['.' => '-']) . '.sqlite');
            return $tenant;
        });

        self::created(function (Tenant $tenant) {
            (new CreateLandlordDatabase())->execute($tenant);
            (new CreatePublicStorageForTenant())->execute($tenant);
            (new ActivateDatabase())->execute($tenant);
            (new RunMigrations())->execute($tenant);
            (new RunSeeders())->execute($tenant);
        });

        self::deleted(function (Tenant $tenant) {
            \File::delete($tenant->database);
            \File::deleteDirectory(storage_path('app/public/' . $tenant->slug));
        });
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->domain, dictionary: ['.' => '_']);
    }

}
