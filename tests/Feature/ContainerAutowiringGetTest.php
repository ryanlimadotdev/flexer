<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../Examples.php';

$container = new \Flexer\Container();

it(
	Container::class . '::get [line: '. currentLine() .'] => Assert that object without constructor is returned on get.',
	function () use ($container) {
		expect($container->get(\Examples\WithoutConstructor::class))->toBeInstanceOf(\Examples\WithoutConstructor::class);
	}
);

it(
	Container::class . '::get [line: '. currentLine() .'] => Assert that object with empty constructor is returned on get.',
	function () use ($container) {
		expect($container->get(\Examples\EmptyConstructor::class))->toBeInstanceOf(\Examples\EmptyConstructor::class);
	}
);

it(
	Container::class . '::get [line: '. currentLine() .'] => Assert that object with optional constructor is returned on get.',
	function () use ($container) {
		expect($container->get(\Examples\OptionalConstructor::class))->toBeInstanceOf(\Examples\OptionalConstructor::class);
	}
);