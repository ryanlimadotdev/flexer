<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';

use Flexer\Container;
use Test\Sample\EmptyConstructor;
use Test\Sample\OptionalConstructor;
use Test\Sample\WithoutConstructor;

$container = new Container();

it(
	Container::class . '::has [line: '. currentLine() .'] => Test if null constructor could be resolved w- a callable.',
	function () use ($container) {
		expect($container->has(WithoutConstructor::class))->toBe(true);
	}
);

it(
	Container::class . '::has [line: '. currentLine() .'] => Empty constructor must have has true.',
	function () use ($container) {
		expect($container->has(EmptyConstructor::class))->toBe(true);
	}
);

it(
	Container::class . '::has [line: '. currentLine() .'] => Optional constructor must have has true.',
	function () use ($container) {
		expect($container->has(OptionalConstructor::class))->toBe(true);
	}
);
