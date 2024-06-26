<?php

declare(strict_types=1);

namespace Test\Sample;

class OptionalConstructor
{
	public string $name;
	public string $lastname;

	public function __construct(
		$name = 'Jessie',
		$lastname = 'James',
	)
	{
		$this->name = $name;
		$this->lastname = $lastname;
	}
}