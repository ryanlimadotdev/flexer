<?php

declare(strict_types=1);

namespace Test\Sample;

class SimpleDependency
{
	public function __construct(
		private NormalClass $dependency,
	)
	{
	}
}