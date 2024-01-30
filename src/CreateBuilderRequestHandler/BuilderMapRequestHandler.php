<?php

declare(strict_types=1);

namespace Flexer\CreateBuilderRequestHandler;

use Flexer\Builder;

class BuilderMapRequestHandler extends AbstractMapRequestHandler
{
    public function handle(MapRequest $request): Builder
    {
        if (!$request->isTypeBuilder()) {
            return parent::handle($request);
        }

	    return $request->definition;
    }

    public function setNext(ICreateBuilder $next): ICreateBuilder
    {
        $this->next = $next;
        return $next;
    }
}
