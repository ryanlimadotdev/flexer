<?php

declare(strict_types=1);

namespace Flexer\CreateBuilderRequestHandler;

use Flexer\Builder;

class InstanceMapRequestHandler extends AbstractMapRequestHandler
{
    public function handle(MapRequest $request): Builder
    {
        if (!$request->isTypeInstance()) {
            return parent::handle($request);
        }
        return new Builder(fn () => $request->definition);
    }

    public function setNext(ICreateBuilder $next): ICreateBuilder
    {
        $this->next = $next;
        return $next;
    }

    public static function create(): self
    {
        return new self();
    }
}
