<?php

use Arkitect\Rules\Rule;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Expression\ForClasses\HaveNameMatching;

arkitect_rule('controllers should be named *Controller', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Controllers'))
        ->should(new HaveNameMatching('*Controlleres'));
});
