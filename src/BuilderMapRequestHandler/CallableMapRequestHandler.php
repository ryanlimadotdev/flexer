<?php

declare(strict_types=1);

namespace Flexer\BuilderMapRequestHandler;

use Flexer\Builder;

class CallableMapRequestHandler extends AbstractBuilderMapRequestHandler
{
    public function handle(BuilderAddRequest $request): Builder
    {
        if (!$request->isTypeCallable()) {
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
