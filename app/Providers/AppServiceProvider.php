<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            DB::connection()->getPdo();
            $dbName = DB::connection()->getDatabaseName();
            Log::info("Database connected successfully: {$dbName}");
        } catch (\Exception $e) {
            Log::error("Database connection failed: " . $e->getMessage());
            echo "Database connection failed: " . $e->getMessage() . PHP_EOL;
        }
    }
}
