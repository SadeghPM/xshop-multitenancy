<?php
namespace Xshop\Multitenancy\Actions;

use Database\Seeders\AreaSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\EvaluationSeeder;
use Database\Seeders\GfxSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\InvoiceSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\PartSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\PropSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\SliderSeeder;
use Database\Seeders\StateSeeder;
use Database\Seeders\TransportSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\VisitorSeeder;
use Database\Seeders\XLangSeeder;
use Xshop\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

class RunSeeders
{
    public function execute(Tenant $tenant)
    {
        $seeders = [
            XLangSeeder::class,
            UserSeeder::class,
            GroupSeeder::class,
            PostSeeder::class,
            StateSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            PropSeeder::class,
            ProductSeeder::class,
            CommentSeeder::class,
            SettingSeeder::class,
            GfxSeeder::class,
            AreaSeeder::class,
            InvoiceSeeder::class,
            VisitorSeeder::class,
            TransportSeeder::class,
            MenuSeeder::class,
            SliderSeeder::class,
            PartSeeder::class,
            EvaluationSeeder::class,
        ];

        foreach ($seeders as $seeder) {
            Artisan::call('db:seed', [
                '--class' => $seeder,
                '--database' => $tenant->slug,
            ]);
        }
    }
}
