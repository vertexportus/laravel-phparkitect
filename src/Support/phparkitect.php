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

return static function (Config $config): void {
    $psr4Namespaces = collect(
        Arr::get(json_decode(file_get_contents('composer.json'), true), 'autoload.psr-4')
    )->filter(
        fn ($value, $key) => !Str::startsWith($key, 'Database\\')
    )->toArray();

    $rules = [];
    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Controller'))
        ->should(new HaveNameMatching('*Controllereres'))
        ->because('we want uniform naming');

    foreach ($psr4Namespaces as $namespace => $path) {
        foreach($rules as $rule) {
            $config->add(
                ClassSet::fromDir($path),
                $rule
            );
        }
    }
};
