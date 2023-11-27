<?php

declare(strict_types=1);

require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../Examples.php';

use Flexer\Container;

$container = new Container();

it(
	Container::class . '::add [line: '. currentLine() .'] => Assert that closure could be used as builder',
	function () use ($container) {
		$container->add([\Examples\EmptyClass::class => fn () => new \Examples\EmptyClass()]);
		$container->add(\Examples\EmptyClass::class, fn () => new \Examples\EmptyClass());
	}
)->throwsNoExceptions();

it(
	Container::class . '::add [line: '. currentLine() .'] => Assert that function name could be used as builder',
	function () use ($container) {
		$container->add([\Examples\EmptyClass::class => 'getNormalClass']);
		$container->add(\Examples\EmptyClass::class, 'emptyClassFactory');
	}
)->throwsNoExceptions();

it(
	Container::class . '::add [line: '. currentLine() .'] => Assert that Class Closure Object is allowed as builder builder',
	function () use ($container) {
		$container->add([\Examples\FactoryMethodClass::class => \Examples\FactoryMethodClass::create(...)]);
		$container->add(\Examples\FactoryMethodClass::class, \Examples\FactoryMethodClass::create(...));
	}
)->throwsNoExceptions();

it(
	Container::class . '::add [line: '. currentLine() .'] => Assert tha a instance of id could be used as definition',
	function () use ($container) {
		$container->add(\Examples\NormalClass::class, new \Examples\NormalClass('Ryan', 'Lima'));
	}
)->throwsNoExceptions();
