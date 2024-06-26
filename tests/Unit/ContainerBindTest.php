<?php

declare(strict_types=1);

use Test\Sample\OptionalConstructor;

require_once __DIR__ . '/../functions.php';

$container = new \Flexer\Container();

it(
	Container::class . '::bind [line: '. currentLine() .'] => Assert that bind properties could be resolved',
	function () use ($container) {
		$container->add(OptionalConstructor::class, fn() => new OptionalConstructor())
			->bind(OptionalConstructor::class, name: 'New name', lastname: 'New lastname');
		/** @var OptionalConstructor $result*/
		$result = $container->get(OptionalConstructor::class);
		expect([$result->name, $result->lastname])->toBe(['New name', 'New lastname']);
	}
);