<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../Examples.php';

$container = new \Flexer\Container();

it(
	Container::class . '::bind [line: '. currentLine() .'] => Assert that bind properties could be resolved',
	function () use ($container) {
		$container->add(\Examples\OptionalConstructor::class, fn() => new \Examples\OptionalConstructor())
			->bind(\Examples\OptionalConstructor::class, name: 'New name', lastname: 'New lastname');
		/** @var \Examples\OptionalConstructor $result*/
		$result = $container->get(\Examples\OptionalConstructor::class);
		expect([$result->name, $result->lastname])->toBe(['New name', 'New lastname']);
	}
);