<?php

declare(strict_types=1);

namespace Flexer\CreateBuilderRequestHandler;

use Flexer\Builder;
use Flexer\Exception\BuildAddHandlerException;

abstract class AbstractICreateBuilder implements ICreateBuilder
{
    protected ICreateBuilder $next;

	final public function __construct()
	{
    }

	public static function create(): ICreateBuilder
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

    public function setNext(ICreateBuilder $next): ICreateBuilder
    {
        $this->next = $next;
        return $next;
    }
}
