<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 29/12/2016
 * Time: 20:20
 */

namespace Warlof\Seat\Slack\Sso;

use Illuminate\Support\ServiceProvider;
use Warlof\Seat\Slack\Sso\Extensions\SlackProvider;

class SlackSsoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->addRoutes();
        $this->addViews();
        $this->addPublications();
        $this->addTranslations();
        $this->registerServices();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/slacksso.config.php', 'slacksso.config');

        $this->mergeConfigFrom(
            __DIR__ . '/Config/package.sidebar.php', 'package.sidebar');
    }

    private function addTranslations()
    {
        $this->loadTranslationsFrom(
            __DIR__ . '/lang', 'slacksso');
    }

    private function addRoutes()
    {
        if (!$this->app->routesAreCached()) {
            include __DIR__ . '/Http/routes.php';
        }
    }

    private function addViews()
    {
        $this->loadViewsFrom(
            __DIR__ . '/resources/views', 'slacksso');

        $this->publishes([
            __DIR__ . '/resources/views/vendor/web' => resource_path('views/vendor/web')
        ], 'seat-slack-sso');
    }

    private function addPublications()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ]);
    }

    private function registerServices()
    {
        // Slack SSO
        $slack = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $slack->extend('slack',
            function ($app) use ($slack) {

                $config = $app['config']['services.slack'];

                return $slack->buildProvider(SlackProvider::class, $config);

            }
        );
    }
}