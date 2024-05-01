<?php
declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;
use LaravelArkitect\Managers\RuleManager;

return static function (Config $config): void {
    require __DIR__ . '/helpers.php';

    $psr4Namespaces = collect(
        data_get(json_decode(file_get_contents('composer.json'), true), 'autoload.psr-4')
    )->filter(
        fn ($value, $key) => !Str::startsWith($key, 'Database\\')
    )->toArray();

    $rules = RuleManager::instance()->loadAll()->all();
    foreach ($psr4Namespaces as $namespace => $path) {
        foreach ($rules as $rule) {
            $config->add(
                ClassSet::fromDir($path),
                $rule
            );
        }
    }
};
