<?php

use Arkitect\Rules\Rule;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\Extend;
use VertexPortus\LaravelArkitect\Expression\ForClasses\DirectlyOrIndirectlyExtend;

because('controllers should inherit from Laravel\'s base Controller class', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Controllers'))
        ->should(new DirectlyOrIndirectlyExtend('Illuminate\Routing\Controller'));
});

because('commands should inherit from Laravel\'s base Command class', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Commands'))
        ->should(new DirectlyOrIndirectlyExtend('Illuminate\Console\Command'));
});

because('exceptions should inherit from base PHP Exception class', function () {
    return Rule::allClasses()
        ->except('App\*\ExceptionHandler')
        ->that(new ResideInOneOfTheseNamespaces('App\*\Exceptions'))
        ->should(new DirectlyOrIndirectlyExtend(\Exception::class));
});

because('mails should inherit from Laravel\'s base Mail class', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Mail'))
        ->should(new Extend('Illuminate\Mail\Mailable'));
});

because('providers should inherit from Laravel\'s base Provider class', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Providers'))
        ->should(new DirectlyOrIndirectlyExtend('Illuminate\Support\ServiceProvider'));
});

because('eloquent models should inherit from Eloquent\'s base Model class', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Models'))
        ->should(new DirectlyOrIndirectlyExtend('Illuminate\Database\Eloquent\Model'));
});

because('facades should inherit from Laravel\'s base Facade class', function () {
    return Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\*\Facades'))
        ->should(new Extend('Illuminate\Support\Facades\Facade'));
});
