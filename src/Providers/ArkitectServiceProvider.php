<?php

namespace VertexPortus\LaravelArkitect\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use VertexPortus\LaravelArkitect\Console\TestArkitectCommand;

class ArkitectServiceProvider extends LaravelServiceProvider
{
	/**
	 * @return void
	 */
	public function register(): void
	{
        // TODO
	}

	/**
	 * @return void
	 */
	public function boot(): void
	{
		if (app()->runningInConsole()) {
			$this->commands([
				TestArkitectCommand::class,
			]);
		}
	}
}
