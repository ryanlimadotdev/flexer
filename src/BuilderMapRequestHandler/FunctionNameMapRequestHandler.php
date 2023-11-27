<?php

declare(strict_types=1);

namespace Flexer\BuilderMapRequestHandler;

use Flexer\Builder;
use Flexer\Exception\BuildAddHandlerException;
use Flexer\Exception\BuilderException;

class FunctionNameMapRequestHandler extends AbstractBuilderMapRequestHandler
{
	/**
	 * @throws BuildAddHandlerException
	 * @throws BuilderException
	 */
	public function handle(BuilderAddRequest $request): Builder
    {
        if (!$request->isTypeFunctionName()) {
            return parent::handle($request);
        }

		$functionName = $request->definition;

        return new Builder(
            $functionName(...),
        );
    }

    public function setNext(BuilderMapHandler $next): BuilderMapHandler
    {
        $this->next = $next;
        return $next;
    }
}
