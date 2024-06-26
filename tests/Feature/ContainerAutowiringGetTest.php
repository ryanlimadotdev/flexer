<?php

declare(strict_types=1);

use Flexer\Container;
use Test\Sample\EmptyConstructor;
use Test\Sample\OptionalConstructor;
use Test\Sample\WithoutConstructor;

require_once __DIR__ . '/../functions.php';

$container = new Container();

it(
	Container::class . '::get [line: '. currentLine() .'] => Assert that object without constructor is returned on get.',
	function () use ($container) {
		expect($container->get(WithoutConstructor::class))
			->toBeInstanceOf(WithoutConstructor::class);
	}
);

it(
	Container::class . '::get [line: '. currentLine() .'] => Assert that object with empty constructor is returned on get.',
	function () use ($container) {
		expect($container->get(EmptyConstructor::class))->toBeInstanceOf(EmptyConstructor::class);
	}
);

it(
	Container::class . '::get [line: '. currentLine() .'] => Assert that object with optional constructor is returned on get.',
	function () use ($container) {
		expect($container->get(OptionalConstructor::class))->toBeInstanceOf(OptionalConstructor::class);
	}
);