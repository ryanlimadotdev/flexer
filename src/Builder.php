<?php

declare(strict_types=1);

namespace Ryanl\MyDi;

use ReflectionClass;
use ReflectionException;
use Ryanl\MyDi\Exception\BuilderException as E;

class Builder
{
	private array $propertiesToBind;
	private object $instance;
	private bool $isSingleton = false;

	public function __construct(
        private readonly mixed $builder,
    ) {
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
		var_dump(call_user_func($this->builder, ...$args));
        $this->instance = call_user_func($this->builder, ...$args);
		if (isset($this->propertiesToBind)) {
            $this->resolveBind();
        }
        return $this->instance;
    }
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
