<?php

namespace OxygenModule\Security;

use Oxygen\Core\Blueprint\BlueprintManager;
use Oxygen\Data\BaseServiceProvider;
use OxygenModule\Security\Repository\DoctrineLoginLogRepository;
use OxygenModule\Security\Repository\LoginLogRepositoryInterface;

class SecurityServiceProvider extends BaseServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot() {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'oxygen/mod-security');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'oxygen/mod-security');

        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('resources/lang/vendor/oxygen/mod-security'),
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/oxygen/mod-security')
        ]);

        $this->app[BlueprintManager::class]->loadDirectory(__DIR__ . '/../resources/blueprints');

        $this->app['events']->listen('auth.login.successful', LoginLogSubscriber::class . '@onLoginSuccessful');
        $this->app['events']->listen('auth.logout.successful', LoginLogSubscriber::class . '@onLogout');
        $this->app['events']->listen('auth.login.failed', LoginLogSubscriber::class . '@onLoginFailed');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */

	public function register() {
        $this->loadEntitiesFrom(__DIR__ . '/Entity');
        $this->app->bind(LoginLogRepositoryInterface::class, DoctrineLoginLogRepository::class);
    }

}
