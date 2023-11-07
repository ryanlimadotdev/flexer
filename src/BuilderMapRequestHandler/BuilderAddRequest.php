<?php

declare(strict_types=1);

namespace Ryanl\MyDi\BuilderMapRequestHandler;

use Ryanl\MyDi\Builder;

readonly class BuilderAddRequest
{
    private BuilderAddRequestType $type;

    public function __construct(
        public string $id,
        public mixed $definition = null,
    ) {
        $this->setTypeForIndividualBuilder();
    }

    public static function create(
        string $idOrCollection,
        mixed $definition = null,
    ): BuilderAddRequest {
        return new static($idOrCollection, $definition);
    }

    private function setTypeForIndividualBuilder(): void
    {
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

        $this->type = BuilderAddRequestType::FunctionName;
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
