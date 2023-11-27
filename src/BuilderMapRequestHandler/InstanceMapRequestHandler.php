<?php

declare(strict_types=1);

namespace Flexer\BuilderMapRequestHandler;

use Flexer\Builder;

class InstanceMapRequestHandler extends AbstractBuilderMapRequestHandler
{
    public function handle(BuilderAddRequest $request): Builder
    {
        if (!$request->isTypeInstance()) {
            return parent::handle($request);
        }
        return new Builder(fn () => $request->definition);
    }

    public function setNext(BuilderMapHandler $next): BuilderMapHandler
    {
        $this->next = $next;
        return $next;
    }

    public static function create(): self
    {
        return new self();
    }
}
