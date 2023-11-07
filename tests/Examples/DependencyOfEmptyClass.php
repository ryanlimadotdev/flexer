<?php

declare(strict_types=1);

class DependencyOfEmptyClass
{
    public function __construct(
        private EmptyClass $emptyClass,
    )
    {
    }
}