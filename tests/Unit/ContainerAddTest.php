<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../Examples.php';

use Flexer\Container;
use Flexer\Exception\ContainerException;

$container = new Container();

it(
	Container::class . '::add [line: '. currentLine() .'] => Assert that when using a non string offset in array as add parameter throws.',
	function () use ($container) {
		$container->add([0 => fn () => new \Examples\EmptyClass()]);
	}
)->throws(ContainerException::class);
