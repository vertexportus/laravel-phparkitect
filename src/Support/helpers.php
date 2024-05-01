<?php

use VertexPortus\LaravelArkitect\Managers\RuleManager;

if (app()->runningInConsole() && !function_exists('because')) {
    function because(string $because, Callable $function): void {
        RuleManager::instance()->register($because, $function);
    }
}
