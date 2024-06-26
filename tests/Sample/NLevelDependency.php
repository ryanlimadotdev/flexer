<?php

declare(strict_types=1);

namespace Test\Sample;

class NLevelDependency
{
	public function __construct(
		private SimpleDependency $dependency,
	)
	{
	}
}