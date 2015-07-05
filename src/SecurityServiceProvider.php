<?php

namespace OxygenModule\Security;

use Oxygen\Core\Blueprint\BlueprintManager;
use Oxygen\Core\Html\Navigation\Navigation;
use Oxygen\Data\BaseServiceProvider;
use Oxygen\Preferences\PreferencesManager;
use Oxygen\Preferences\Transformer\JavascriptTransformer;

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

        $this->addPreferencesToLayout();
	}

	/**
	 * Adds items the the admin navigation.
	 *
	 * @return void
	 */

	public function addNavigationItems() {
		$blueprints = $this->app[BlueprintManager::class];
		$blueprint = $blueprints->get('Auth');
		$nav = $this->app[Navigation::class];

		$nav->add($blueprint->getToolbarItem('getInfo'));
		$nav->add($blueprint->getToolbarItem('getPreferences'));
		$nav->add($blueprint->getToolbarItem('postLogout'));
	}

	/**
     * Adds some embedded Javascript code that contains the user's preferences.
     *
     * @return void
     */

    protected function addPreferencesToLayout() {
        $this->app['events']->listen('oxygen.layout.body.after', function() {
		    if($this->app['auth']->check()) {
		        $javascriptTransformer = new JavascriptTransformer();
		        echo $javascriptTransformer->fromRepository($this->app['auth']->user()->getPreferences(), 'user');
		    }
        });
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */

	public function register() {}

}
