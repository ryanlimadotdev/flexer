<?php

declare(strict_types=1);

namespace Test\Sample;

class DependencyOfEmptyClass
{
	public function __construct(
		private EmptyClass $emptyClass,
	)
	{
	}
}