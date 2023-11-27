<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../Examples.php';

use Flexer\Container;

$container = new Container();

it(
	Container::class . '::has [line: '. currentLine() .'] => Test if null constructor could be resolved w- a callable.',
	function () use ($container) {
		expect($container->has(\Examples\WithoutConstructor::class))->toBe(true);
	}
);

it(
	Container::class . '::has [line: '. currentLine() .'] => Empty constructor must have has true.',
	function () use ($container) {
		expect($container->has(\Examples\EmptyConstructor::class))->toBe(true);
	}
);

it(
	Container::class . '::has [line: '. currentLine() .'] => Optional constructor must have has true.',
	function () use ($container) {
		expect($container->has(\Examples\OptionalConstructor::class))->toBe(true);
	}
);
