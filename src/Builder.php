<?php

declare(strict_types=1);

namespace Flexer;

use Flexer\Exception\BuilderException as E;
use ReflectionClass;
use ReflectionException;

class Builder
{
	/** @var array<string, mixed>*/
	private array $propertiesToBind;
	private object $instance;
	private bool $isSingleton = false;

	/**
	 * @throws E
	 */
	public function __construct(
        private readonly mixed $builder,
    ) {
		if (!\is_callable($this->builder)) {
			throw new E(
				E::TRYING_TO_ASSIGN_A_NON_CALLABLE_TO_BUILDER,
				E::TRYING_TO_ASSIGN_A_NON_CALLABLE_TO_BUILDER_CODE
			);
		}
    }

	/**
	 * @throws E
	 * @throws ReflectionException
	 */
    public function __invoke(mixed ...$args): object
    {
		if ($this->isSingleton and isset($this->instance)) {
            return $this->instance;
        }
        $this->instance = call_user_func($this->builder, ...$args);
		if (isset($this->propertiesToBind)) {
            $this->resolveBind();
        }
        return $this->instance;
    }

	/**
	 * @throws E
	 */
	public static function create(mixed $builder): self
    {
        return new self($builder);
    }

	public function bind(mixed ...$params): void
	{
		$this->propertiesToBind = $params;
	}

	/**
	 * @throws E
	 */
	private function resolveBind(): void
	{
		$reflectionClass = new ReflectionClass($this->instance);
		foreach ($this->propertiesToBind as $property => $value) {
			if (!$reflectionClass->hasProperty($property)) {
				throw new E(E::TRYING_BIND_UNDEFINED_PROPERTY, E::TRYING_BIND_UNDEFINED_PROPERTY_CODE);
			}
			$reflectionProperty = $reflectionClass->getProperty($property);
			$reflectionProperty->setAccessible(true);
			$reflectionProperty->setValue($this->instance, $value);
		}
	}

	public function singleton(bool $mode): void
	{
		$this->isSingleton = $mode;
	}
}
