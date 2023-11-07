<?php

declare(strict_types=1);

namespace Ryanl\MyDi\BuilderMapRequestHandler;

use JetBrains\PhpStorm\Pure;
use Ryanl\MyDi\Builder;
use Ryanl\MyDi\Exception\BuildAddHandlerException;

abstract class AbstractBuilderMapRequestHandler implements BuilderMapHandler
{
    protected BuilderMapHandler $next;

    #[Pure] public static function create(): BuilderMapHandler
    {
        return new static();
    }

	/**
	 * @throws BuildAddHandlerException
	 */
	public function handle(BuilderAddRequest $request): Builder
	{
		if (!isset($this->next)) {
			throw new BuildAddHandlerException(
                BuildAddHandlerException::UNIMPLEMENTED,
                BuildAddHandlerException::UNIMPLEMENTED_CODE
            );
        }
		return $this->next->handle($request);
	}

    public function setNext(BuilderMapHandler $next): BuilderMapHandler
    {
        $this->next = $next;
        return $next;
    }
}
