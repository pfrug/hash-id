<?php

namespace Pfrug\HashId;

use Illuminate\Support\ServiceProvider;
use Jenssegers\Optimus\Optimus;
use Pfrug\HashId\Console\Commands\RegenerateIdsCommand;

class HashIdServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadConfig();
    }

    public function register(): void
    {
        $this->app->singleton(Optimus::class, function ($app) {
            $config = config('hashid');
            return new Optimus($config['prime'], $config['inverse'], $config['random']);
        });

        $this->commands([
            RegenerateIdsCommand::class,
        ]);
    }

    private function loadConfig(): void
    {
        $this->publishes(
            [
                __DIR__ . '/../config/hashid.php' => config_path('hashid.php'),
            ],
            'hashid-config'
        );
    }
}