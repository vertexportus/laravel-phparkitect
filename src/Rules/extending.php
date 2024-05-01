<?php

use Arkitect\Rules\Rule;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use LaravelArkitect\Expression\ForClasses\DirectlyOrIndirectlyExtend;

arkitect_rule('controllers should inherit from Laravel\'s base controller', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Controllers'))
        ->should(new DirectlyOrIndirectlyExtend('Illuminate\Routing\Controller'));
});
