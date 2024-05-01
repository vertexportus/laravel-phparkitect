<?php

namespace LaravelArkitect\Managers;

use Arkitect\Rules\Rule;
use Arkitect\Rules\AllClasses;
use LaravelArkitect\Contracts\HelperContract;

class RuleManager implements HelperContract
{
    private static RuleManager $instance;
    public static function instance() : RuleManager {
        return self::$instance ??= new RuleManager();
    }

    private array $rules = [];

    public function register(string $because, Callable $callback): void {
        $this->rules[] = $callback()->because($because);
    }

    public function loadDefault(): self {
        $this->loadFrom(__DIR__.'/../Rules');
        return $this;
    }

    public function loadProject(): self {
        $this->loadFrom(base_path('tests/Architecture'));
        return $this;
    }

    public function loadAll(): self {
        return $this->loadDefault()->loadProject();
    }

    public function all(): array {
        return $this->rules;
    }

    private function loadFrom(string $path): void {
        $this->loadFilesFrom($path);
        $dirs = glob($path . '/*', GLOB_ONLYDIR);
        foreach ($dirs as $dir) {
            $this->loadFilesFrom($dir);
        }
    }

    private function loadFilesFrom(string $path): void {
        $files = glob($path . '/*.php');
        foreach ($files as $file) {
            require $file;
        }
    }
}
