<?php

declare(strict_types=1);

namespace Flexer\BuilderMapRequestHandler;

use Flexer\Builder;

interface BuilderMapHandler
{
    public function handle(BuilderAddRequest $request): Builder;
    public function setNext(BuilderMapHandler $next): BuilderMapHandler;
}
