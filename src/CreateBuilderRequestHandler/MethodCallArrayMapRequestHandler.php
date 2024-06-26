<?php

declare(strict_types=1);

namespace Flexer\CreateBuilderRequestHandler;

use Flexer\Builder;
use Flexer\Exception\BuildAddHandlerException;
use Flexer\Exception\BuilderException;

class MethodCallArrayMapRequestHandler extends AbstractMapRequestHandler
{
	/**
	 * @throws BuildAddHandlerException
	 * @throws BuilderException
	 */
	public function handle(MapRequest $request): Builder
    {
        if (!$request->isTypeMethodCallArray()) {
            return parent::handle($request);
        }

        return new Builder(
			($request->definition)(...)
        );
    }

    public function setNext(ICreateBuilder $next): ICreateBuilder
    {
        $this->next = $next;
        return $next;
    }
}
