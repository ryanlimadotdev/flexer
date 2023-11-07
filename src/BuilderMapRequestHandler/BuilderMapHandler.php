<?php

declare(strict_types=1);

namespace Ryanl\MyDi\BuilderMapRequestHandler;

use Ryanl\MyDi\Builder;

interface BuilderMapHandler
{
    public function handle(BuilderAddRequest $request): Builder;
    public function setNext(BuilderMapHandler $next): BuilderMapHandler;

}