<?php

declare(strict_types=1);

namespace Flexer\CreateBuilderRequestHandler;

use Flexer\Builder;

class MethodCallArrayMapRequestHandler extends AbstractMapRequestHandler
{
    public function handle(MapRequest $request): Builder
    {
        if (!$request->isTypeMethodCallArray()) {
            return parent::handle($request);
        }

        return new Builder(
            $request->definition,
        );
    }

    public function setNext(ICreateBuilder $next): ICreateBuilder
    {
        $this->next = $next;
        return $next;
    }
}
