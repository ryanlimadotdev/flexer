<?php

declare(strict_types=1);

namespace Flexer\CreateBuilderRequestHandler;

use Flexer\Builder;
use Flexer\Exception\BuildAddHandlerException as E;

final readonly class MapRequest
{
	private BuilderAddRequestType $type;

	/**
	 * @throws E
	 */
	public function __construct(
        public string $id,
        public mixed $definition,
    ) {

	    if ($this->definition instanceof $this->id) {
		    $this->type = BuilderAddRequestType::Instance;
		    return;
	    }

	    if ($this->definition instanceof Builder) {
		    $this->type = BuilderAddRequestType::Builder;
		    return;
	    }

	    if (is_string($this->definition)) {
		    $this->type = BuilderAddRequestType::FunctionName;
		    return;
	    }

	    if (is_callable($this->definition)) {
		    $this->type = BuilderAddRequestType::Callable;
		    return;
	    }

		if (
			is_array($this->definition) and
			(is_object($this->definition[0]) or is_string($this->definition[0])) and
			(is_string($this->definition[1]))
		) {
			$this->type = BuilderAddRequestType::MethodCallArray;
			return;
		}

		throw new E(
			E::UNIMPLEMENTED,
			E::UNIMPLEMENTED_CODE
		);
    }

    public static function create(
        string $idOrCollection,
        mixed $definition = null,
    ): MapRequest {
        return new MapRequest($idOrCollection, $definition);
    }

    public function isTypeFunctionName(): bool
    {
        return $this->type === BuilderAddRequestType::FunctionName;
    }

    public function isTypeMethodCallArray(): bool
    {
        return $this->type === BuilderAddRequestType::MethodCallArray;
    }

    public function isTypeBuilder(): bool
    {
        return $this->type === BuilderAddRequestType::Builder;
    }

    public function isTypeInstance(): bool
    {
        return $this->type === BuilderAddRequestType::Instance;
    }

    public function isTypeCallable(): bool
    {
        return $this->type === BuilderAddRequestType::Callable;
    }
}
