<?php

declare(strict_types=1);

namespace Flexer\CreateBuilderRequestHandler;

use Flexer\Builder;

interface ICreateBuilder
{
    public function handle(MapRequest $request): Builder;
    public function setNext(ICreateBuilder $next): ICreateBuilder;
}
