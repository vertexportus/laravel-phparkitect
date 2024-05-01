<?php

use LaravelArkitect\Managers\RuleManager;

if (app()->runningInConsole() && !function_exists('arkitect_rule')) {
    function arkitect_rule(string $because, Callable $function): void {
        RuleManager::instance()->register($because, $function);
    }
}
