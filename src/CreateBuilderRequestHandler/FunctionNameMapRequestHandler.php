<?php

declare(strict_types=1);

namespace Flexer\CreateBuilderRequestHandler;

use Flexer\Builder;
use Flexer\Exception\BuildAddHandlerException;
use Flexer\Exception\BuilderException;

class FunctionNameMapRequestHandler extends AbstractMapRequestHandler
{
	/**
	 * @throws BuildAddHandlerException
	 * @throws BuilderException
	 */
	public function handle(MapRequest $request): Builder
    {
        if (!$request->isTypeFunctionName()) {
            return parent::handle($request);
        }

		$functionName = $request->definition;

        return new Builder(
            $functionName(...),
        );
    }

    public function setNext(ICreateBuilder $next): ICreateBuilder
    {
        $this->next = $next;
        return $next;
    }
}
