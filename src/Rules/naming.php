<?php

use Arkitect\Rules\Rule;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Expression\ForClasses\HaveNameMatching;

because('it\'s a Laravel naming convention', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Controllers'))
        ->should(new HaveNameMatching('*Controller'));
});

because('it\'s a Laravel naming convention', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Exceptions'))
        ->should(new HaveNameMatching('*Exception'));
});

because('it\'s a Laravel naming convention', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Mails'))
        ->should(new HaveNameMatching('*Mail'));
});

because('it\'s a Laravel naming convention', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Providers'))
        ->should(new HaveNameMatching('*ServiceProvider'));
});

because('it\'s a Laravel naming convention', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Repositories'))
        ->should(new HaveNameMatching('*Repository'));
});

because('it\'s a Laravel naming convention', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Services'))
        ->should(new HaveNameMatching('*Service'));
});

because('it\'s a Laravel naming convention', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Commands'))
        ->should(new HaveNameMatching('*Command'));
});

because('it\'s a Laravel naming convention', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Jobs'))
        ->should(new HaveNameMatching('*Job'));
});

because('it\'s a PHP naming convention', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Exceptions'))
        ->should(new HaveNameMatching('*Exception'));
});

because('it\'s a Laravel naming convention', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Contracts'))
        ->should(new HaveNameMatching('*Contract'));
});
