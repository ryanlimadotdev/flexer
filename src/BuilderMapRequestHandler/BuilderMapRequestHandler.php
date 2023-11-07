<?php

declare(strict_types=1);

namespace Ryanl\MyDi\BuilderMapRequestHandler;

use Ryanl\MyDi\Builder;

class BuilderMapRequestHandler extends AbstractBuilderMapRequestHandler
{

    public function handle(BuilderAddRequest $request): Builder
    {
        if (!$request->isTypeBuilder()) {
            return parent::handle($request);
        }
        /** @var Builder $definition  */
        $definition = $request->definition;

        return $definition;
    }

    public function setNext(BuilderMapHandler $next): BuilderMapHandler
    {
        $this->next = $next;
        return $next;
    }
}
