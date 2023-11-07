<?php

declare(strict_types=1);


class NormalClass
{
    public function __construct
    (
        public string $name,
        public string $lastname,
    )
    {
    }

    public static function create()
    {
        return new NormalClass('Ryan', 'Lima');
    }
}