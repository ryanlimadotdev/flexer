<?php

declare(strict_types=1);

namespace Test\Sample;

class FactoryMethodClass
{
	public static function create($a = 'SAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'): FactoryMethodClass
	{
		var_dump($a);
		return new FactoryMethodClass();
	}
}