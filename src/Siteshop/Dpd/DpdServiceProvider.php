<?php namespace Siteshop\Dpd;

use Illuminate\Support\ServiceProvider;

class DpdServiceProvider extends ServiceProvider {

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
    public function boot()
    {
        $this->package('siteshop/dpd');
    }

    /**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['dpd'] = $this->app->share(function($app)
		{
			return new Dpd($app['config']->get('dpd::settings'));
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('dpd');
	}

}
