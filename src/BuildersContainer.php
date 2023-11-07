<?php

declare(strict_types=1);

namespace Ryanl\MyDi;

use ArrayAccess;
use ArrayIterator;
use Exception;
use IteratorAggregate;
use Ryanl\MyDi\Exception\BuilderContainerException as E;

class BuildersContainer implements IteratorAggregate, ArrayAccess
{
    /** @var $content array<string, Builder> */
    private array $content = [];

	/**
	 *
	 * @throws E
	 */
    public static function fromArray(array $collection): self
    {
        $builderContainer = new self();
        /** @var $id string */
        foreach ($collection as $id => $callable) {
            if (!is_string($id)) {
                throw new E(E::TRYING_TO_USE_A_NON_STRING_AS_OFFSET, E::TRYING_TO_USE_A_NON_STRING_AS_OFFSET_CODE);
            }
            $builderContainer[$id] = $callable;
        }

        return $builderContainer;
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->content);
    }

    public function offsetGet(mixed $offset): Builder
    {
        return $this->content[$offset];
    }

	/**
	 * @throws E
	 */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof Builder) {
            throw new E(E::TRYING_TO_ADD_A_NON_BUILDER_INSTANCE, E::TRYING_TO_ADD_A_NON_BUILDER_INSTANCE_CODE);
        }
        if (!is_string($offset)) {
	        throw new E(E::TRYING_TO_USE_A_NON_STRING_AS_OFFSET, E::TRYING_TO_USE_A_NON_STRING_AS_OFFSET_CODE);
        }

        $this->content[$offset] = $value;
    }

	/**
	 * @throws E
	 */
    public function add(mixed $offset, mixed $value): void
    {
        $this->offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->content[$offset]);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->content);
    }

	/**
	 * @throws Exception
	 */
    public function merge(BuildersContainer $value): void
    {
        $this->content += iterator_to_array($value->getIterator());
    }
}
