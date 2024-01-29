<?php

declare(strict_types=1);

namespace Flexer\BuilderMapRequestHandler;

use Flexer\Builder;

class MethodCallArrayMapRequestHandler extends AbstractBuilderMapRequestHandler
{
    public function handle(BuilderAddRequest $request): Builder
    {
        if (!$request->isTypeMethodCallArray()) {
            return parent::handle($request);
        }

        return new Builder(
            $request->definition,
        );
    }

    public function setNext(BuilderMapHandler $next): BuilderMapHandler
    {
        $this->next = $next;
        return $next;
    }
}
