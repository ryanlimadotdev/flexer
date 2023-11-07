<?php

declare(strict_types=1);

namespace Ryanl\MyDi;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Ryanl\MyDi\BuilderMapRequestHandler\BuilderMapHandler;
use Ryanl\MyDi\BuilderMapRequestHandler\BuilderAddRequest;
use Ryanl\MyDi\BuilderMapRequestHandler\BuilderMapRequestHandler;
use Ryanl\MyDi\BuilderMapRequestHandler\CallableMapRequestHandler;
use Ryanl\MyDi\BuilderMapRequestHandler\FunctionNameMapRequestHandler;
use Ryanl\MyDi\BuilderMapRequestHandler\InstanceMapRequestHandler;
use Ryanl\MyDi\BuilderMapRequestHandler\MethodCallArrayMapRequestHandler;
use Ryanl\MyDi\Exception\BuilderContainerException;
use Ryanl\MyDi\Exception\ContainerException as E;
use Ryanl\MyDi\Exception\NotFoundException;

/**
 * Implements the PSR11 that describe the behavior of
 * inter framework compatible DI Container
 *
 * @see ContainerInterface
 * @author Ryan Lima <me@ryanlima.dev>
 */
class Container implements ContainerInterface
{
	public final const STRICT_MODE = 0;
	public final const SHARED_INSTANCES = 1;

	/** @var array<bool> $modes */
	private array $modes = [];
	private BuilderMapHandler $addRequestHandler;
	private BuildersContainer $definitions;

	/**
	 * @param array<string, mixed> $builders
	 * @throws BuilderContainerException
	 * @throws E
	 */
	public function __construct(
		array $builders = [],
	) {

		$this->handlersSetUp();
		$this->definitions = new BuildersContainer();

		$this->add($builders);
	}

	private function handlersSetUp(): void
	{
		$addHandler = FunctionNameMapRequestHandler::create();
		$addHandler->setNext(BuilderMapRequestHandler::create())
			->setNext(CallableMapRequestHandler::create())
			->setNext(MethodCallArrayMapRequestHandler::create())
			->setNext(InstanceMapRequestHandler::create());

		$this->addRequestHandler = $addHandler;
	}

	/**
	 * @param string|array<string, mixed> $entryOrCollection
	 * Closure, function qualified name, Class Clojure Object
	 *
	 *
	 * @throws BuilderContainerException
	 * @throws E
	 */
	public function add(
		string|array $entryOrCollection,
		mixed $definition = null,
	): self {
		if (!is_array($entryOrCollection)) {
			$this->addRequest($entryOrCollection, $definition);
			return $this;
		}
		foreach ($entryOrCollection as $id => $definition) {
			if (!is_string($id)) {
				throw new E(
					E::FORBIDDEN_DEFINITION_OFFSET . $id,
					E::FORBIDDEN_DEFINITION_OFFSET_CODE
				);
			}
			$this->addRequest($id, $definition);
		}

		return $this;
	}

	/**
	 * @throws BuilderContainerException
	 */
	public function addRequest(string $id, mixed $definition): void
	{
		$newBuilder = $this->addRequestHandler->handle(BuilderAddRequest::create($id, $definition));
		if ($this->modes[self::SHARED_INSTANCES] ??= false) {
			$newBuilder->singleton(true);
		}
		$this->definitions->add($id, $newBuilder);
	}

	public function setMode(int $mode, bool $status): self
	{
		$this->modes[$mode] = $status;
		return $this;
	}


	/**
	 * {@inheritdoc}
	 */
	public function has(string $id): bool
	{
		if (isset($this->modes[Container::STRICT_MODE])) {
			return isset($this->definitions[$id]);
		}

		return $this->couldResolve($id);
	}

	private function couldResolve(string $id): bool
	{
		if (!class_exists($id)) {
            return false;
        }

		$reflection = new ReflectionClass($id);
		$constructor = $reflection->getConstructor();

		if (is_null($constructor)) {
			$this->addEmpty($id);
			return true;
		}

		$constructorParameters = $constructor->getParameters();

		foreach ($constructorParameters as $parameter) {
			if ($parameter->isDefaultValueAvailable()) {
                break;
            }

			if (
				!isset($this->definitions[(string)$parameter->getType()]) &&
				!$this->has((string)$parameter->getType())
			) {
                return false;
            }
		}

		return true;
	}

	/**
	 * Returns an instance of the specified class **$id** or throw an
	 * NotFoundException.
	 *
	 * @throws ReflectionException
	 * @throws NotFoundException
	 */
	public function get(string $id): mixed
	{
		if (isset($this->definitions[$id])) {
            return $this->definitions[$id]();
        }
		if ($this->couldResolve($id)) {
            return $this->resolve($id);
        }
		throw new NotFoundException("Cannot resolve for $id");
	}

	/**
	 * @throws NotFoundException
	 * @throws ReflectionException
	 */
	private function resolve(string $id): object
	{

		$reflectionClass = new ReflectionClass($id);

		$constructor = $reflectionClass->getConstructor();
		$constructorParameters = $constructor?->getParameters();

		if (is_null($constructor) or empty($constructorParameters)) {
			$this->addEmpty($id);
			return new $id();
		}

		$parametersToBind = [];

		$allHaveDefaultValue = array_reduce(
			$constructorParameters,
			static fn(
				bool $carry,
				ReflectionParameter $currentParameter
			) => $carry and $currentParameter->isDefaultValueAvailable(),
			true
		);

		if ($allHaveDefaultValue) {
			$this->addEmpty($id);
			return new $id();
		}

		foreach ($constructorParameters as $parameter) {
			$parametersToBind[$parameter->getName()] = $this->get((string)$parameter->getType());
		}

		$resolvePattern = fn () => new $id(... $parametersToBind);

		$this->addResolvePattern($id, $resolvePattern);
		return $resolvePattern();
	}

	/**
	 * @throws E
	 */
	public function bind(string $id, mixed ...$properties): self
	{
		if (!$this->has($id)) {
			throw new E(
				E::TRYING_BIND_UNDEFINED_ENTRY,
				E::TRYING_BIND_UNDEFINED_ENTRY_CODE
			);
		}
		$this->definitions[$id]->bind(... $properties);
		return $this;
	}

	/**
	 * @throws E throws an exception if you provide an unsolvable $id
	 */
	public function singleton(string $id, bool $mode): self
	{
		if (!$this->has($id)) {
			throw new E(
				E::TRYING_TO_SET_AS_SHARED_UNDEFINED_ENTRY,
				E::TRYING_TO_SET_AS_SHARED_UNDEFINED_ENTRY_CODE
			);
		}
		$this->definitions[$id]->singleton($mode);
		return $this;
	}

	private function addEmpty($id): void
	{
		$this->definitions[$id] = Builder::create(fn () => new $id());
	}

	private function addResolvePattern(string $id, $resolvePattern): void
	{
		$this->definitions[$id] = Builder::create($resolvePattern);
	}
}