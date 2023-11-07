<?php

declare(strict_types=1);


class SimpleDependency
{
    public function __construct
    (
        private NormalClass $dependency,
    )
    {
    }
}