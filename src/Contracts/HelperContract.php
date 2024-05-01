<?php

namespace VertexPortus\LaravelArkitect\Contracts;

interface HelperContract
{
    function register(string $because, Callable $callback): void;
}
