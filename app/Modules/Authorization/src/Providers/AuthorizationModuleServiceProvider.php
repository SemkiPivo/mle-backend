<?php
namespace Authorization\Providers;

use Authorization\Interfaces\Services\VerifyCodeServiceInterface;
use Authorization\Services\VerifyCodeService;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class AuthorizationModuleServiceProvider extends ServiceProvider
{
    public array $bindings = [
        VerifyCodeServiceInterface::class => VerifyCodeService::class,
    ];
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api/auth')
                ->group(__DIR__.'/../../routes/auth.php');
        });
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $config = __DIR__.'/../../config/code_verification.php';

        $this->publishes([$config => $config]);
        $this->publishes([$config => base_path('config/code_verification.php')]);

        $this->mergeConfigFrom($config, 'authorization');
    }

}
