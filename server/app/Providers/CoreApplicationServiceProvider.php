<?php
declare(strict_types=1);

namespace App\Providers;

use App\Logging\LaravelLogger;
use App\Logging\Logger;
use App\Logging\NoopsLogger;
use Illuminate\Support\ServiceProvider;

/**
 * Class CoreApplicationServiceProvider
 * @package App\Providers
 */
final class CoreApplicationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        // Logger
        $logger = null;
        if (env('APP_ENV') === 'testing') {
            // テスト実行時はログを出力しない
            $logger = new NoopsLogger();
        } else {
            $logger = new LaravelLogger();
        }
        $this->app->bind(Logger::class, function () use ($logger) {
            return $logger;
        });
    }
}
