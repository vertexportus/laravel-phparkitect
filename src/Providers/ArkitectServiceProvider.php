<?php

namespace LaravelArkitect\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelArkitect\Console\TestArkitectCommand;

class ArkitectServiceProvider extends ServiceProvider
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
