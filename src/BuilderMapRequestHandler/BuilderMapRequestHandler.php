<?php

declare(strict_types=1);

namespace Flexer\BuilderMapRequestHandler;

use Flexer\Builder;

class BuilderMapRequestHandler extends AbstractBuilderMapRequestHandler
{
    public function handle(BuilderAddRequest $request): Builder
    {
        if (!$request->isTypeBuilder()) {
            return parent::handle($request);
        }

	    return $request->definition;
    }

    public function setNext(BuilderMapHandler $next): BuilderMapHandler
    {
        $this->next = $next;
        return $next;
    }
}
